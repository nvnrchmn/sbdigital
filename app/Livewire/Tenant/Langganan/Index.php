<?php

namespace App\Livewire\Tenant\Langganan;

use Livewire\Component;
use App\Models\Plan;
use App\Models\Rumah;
use App\Models\Warga;
use App\Models\TenantSubscription;
use App\Services\LogikrafService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class Index extends Component
{
    public $plan;
    public $rumahCount = 0;
    public $wargaCount = 0;

    public function mount()
    {
        abort_unless(auth()->user()->hasRole('Tenant Owner'), 403, 'Akses ditolak.');

        $plan_id = tenant('plan_id');
        if ($plan_id) {
            // Need to get the Plan using the central connection
            $this->plan = Plan::find($plan_id);
        }

        $this->rumahCount = Rumah::count();
        $this->wargaCount = Warga::count();
    }

    public function subscribe($planId)
    {
        if (!Auth::user()->hasRole('Tenant Owner')) {
            abort(403, 'Akses ditolak. Hanya Tenant Owner yang dapat berlangganan.');
        }

        $plan = Plan::findOrFail($planId);
        $tenantId = tenant('id');

        // Check if there is already a pending subscription for this plan
        $pendingSub = TenantSubscription::where('tenant_id', $tenantId)
                        ->where('plan_id', $plan->id)
                        ->where('status', 'Pending')
                        ->where('checkout_url', '!=', '#')
                        ->first();

        if ($pendingSub) {
            $this->dispatch('notify', message: 'Anda sudah memiliki tagihan pending untuk paket ini.');
            return;
        }

        // Create subscription record
        $subscription = TenantSubscription::create([
            'tenant_id' => $tenantId,
            'plan_id' => $plan->id,
            'amount' => $plan->price,
            'status' => 'Pending',
        ]);

        if ($plan->price > 0) {
            try {
                $invoiceId = "INV-SUB-{$subscription->id}";
                $payerEmail = Auth::user() ? Auth::user()->email : 'no-email@sbdigital.com';
                $description = "Langganan Paket {$plan->name} untuk Portal {$tenantId}";

                $logikraf = new LogikrafService();
                
                Log::info('Livewire Langganan: Mengirim request createMasterInvoice', [
                    'invoice_id' => $invoiceId,
                    'tenant_id' => $tenantId,
                    'price' => $plan->price,
                    'payer_email' => $payerEmail,
                    'description' => $description
                ]);

                $invoice = $logikraf->createMasterInvoice($invoiceId, $tenantId, $plan->price, $payerEmail, $description);

                Log::info('Livewire Langganan: Respon createMasterInvoice', [
                    'response' => $invoice
                ]);

                if ($invoice && isset($invoice['checkout_url'])) {
                    $subscription->update([
                        'external_id' => $invoice['external_id'] ?? $invoiceId,
                        'checkout_url' => $invoice['checkout_url']
                    ]);
                    
                    // Pindahkan pengguna (redirect) langsung ke halaman pembayaran Xendit
                    return redirect()->away($invoice['checkout_url']);
                } else {
                    // Mock for testing if Logikraf is not configured
                    $subscription->update([
                        'external_id' => $invoiceId,
                        'checkout_url' => '#' // Dummy URL
                    ]);
                }
            } catch (\Throwable $e) {
                Log::error('Livewire Langganan Exception: ' . $e->getMessage());
                $subscription->update([
                    'external_id' => $invoiceId ?? 'ERROR',
                    'checkout_url' => 'ERROR: ' . $e->getMessage()
                ]);
            }
        } else {
            // Free plan, automatically mark as paid
            $subscription->update([
                'status' => 'Lunas',
                'paid_at' => now(),
            ]);
            
            $tenant = \App\Models\Tenant::find($tenantId);
            if ($tenant) {
                $tenant->update(['plan_id' => $plan->id]);
            }
            $this->plan = $plan;
        }

        $this->dispatch('notify', message: 'Tagihan langganan berhasil dibuat.');
    }

    public function render()
    {
        $tenantId = tenant('id');
        $allPlans = Plan::orderBy('price')->get();
        $subscriptions = TenantSubscription::where('tenant_id', $tenantId)
                            ->with('plan')
                            ->orderBy('created_at', 'desc')
                            ->get();

        return view('livewire.tenant.langganan.index', [
            'allPlans' => $allPlans,
            'subscriptions' => $subscriptions
        ]);
    }
}
