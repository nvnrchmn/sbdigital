<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Tenant;

class LogikrafWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $payload = $request->getContent();

        // FIX (P2): sebelumnya header('X-Logikraf-Signature') bisa bernilai null
        // kalau header tidak dikirim, dan hash_equals(string, null) melempar TypeError
        // di PHP 8 (strict types) -> response jadi 500 alih-alih 400 yang rapi.
        $signature = $request->header('X-Logikraf-Signature', '');

        $secret = \App\Models\Setting::get('logikraf_webhook_secret', config('logikraf.webhook_secret'));

        if ($signature === '' || !hash_equals(hash_hmac('sha256', $payload, $secret), $signature)) {
            Log::warning('Logikraf Webhook signature mismatch atau tidak ada.');
            return response()->json(['message' => 'Invalid signature'], 400);
        }

        $data = json_decode($payload, true);

        if (isset($data['event']) && $data['event'] === 'invoice.paid') {
            $invoiceId = $data['data']['external_id'] ?? null;

            if ($invoiceId && preg_match('/^INV-([A-Za-z0-9_-]+)-(\d+)$/', $invoiceId, $matches)) {
                $tenantId = $matches[1];
                $iuranId = $matches[2];

                // Initialize tenant
                tenancy()->initialize($tenantId);

                $iuran = \App\Models\PembayaranIuran::find($iuranId);
                if ($iuran) {
                    $iuran->update([
                        'status' => 'Lunas',
                        'paid_at' => now(),
                    ]);
                    Log::info("Iuran $iuranId for tenant $tenantId marked as Lunas.");
                }

                tenancy()->end();
            } elseif ($invoiceId && preg_match('/^INV-SUB-(\d+)$/', $invoiceId, $matches)) {
                $subscriptionId = $matches[1];
                $subscription = \App\Models\TenantSubscription::find($subscriptionId);

                if ($subscription) {
                    $subscription->update([
                        'status' => 'Lunas',
                        'paid_at' => now(),
                    ]);

                    // Update tenant plan
                    $tenant = Tenant::find($subscription->tenant_id);
                    if ($tenant) {
                        $tenant->update(['plan_id' => $subscription->plan_id]);
                    }
                    Log::info("Subscription $subscriptionId marked as Lunas and Tenant {$subscription->tenant_id} updated.");
                }
            }
        }

        return response()->json(['message' => 'Webhook received']);
    }
}
