<?php

namespace App\Livewire\Tenant\Iuran;

use App\Models\PembayaranIuran;
use App\Models\Rumah;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Form extends Component
{
    public ?PembayaranIuran $iuran = null;
    public $id_rumah = '';
    public $bulan = '';
    public $tahun = '';
    public $nominal = '';
    public $status = 'Pending';

    public function mount(PembayaranIuran $iuran = null)
    {
        if (!Auth::user()->hasAnyRole(['Tenant Owner', 'Ketua RT', 'Bendahara'])) {
            abort(403, 'Akses ditolak.');
        }

        if ($iuran && $iuran->exists) {
            $this->iuran = $iuran;
            $this->id_rumah = $iuran->id_rumah;
            $this->bulan = $iuran->bulan;
            $this->tahun = $iuran->tahun;
            $this->nominal = $iuran->nominal;
            $this->status = $iuran->status;
        } else {
            $this->bulan = date('n');
            $this->tahun = date('Y');
            $this->nominal = 100000; // default nominal
        }
    }

    public function save()
    {
        abort_unless(auth()->user()->hasAnyRole(['Tenant Owner', 'Ketua RT', 'Bendahara']), 403, 'Akses ditolak.');

        $this->validate([
            'id_rumah' => 'required|exists:rumah,id',
            'bulan' => 'required|integer|min:1|max:12',
            'tahun' => 'required|integer|min:2000|max:2100',
            'nominal' => 'required|numeric|min:0',
            'status' => 'required|in:Pending,Lunas,Ditolak',
        ]);

        if ($this->iuran) {
            $this->iuran->update([
                'id_rumah' => $this->id_rumah,
                'bulan' => $this->bulan,
                'tahun' => $this->tahun,
                'nominal' => $this->nominal,
                'status' => $this->status,
            ]);
            $this->dispatch('notify', message: 'Data iuran berhasil diubah');
        } else {
            $iuran = PembayaranIuran::create([
                'id_rumah' => $this->id_rumah,
                'bulan' => $this->bulan,
                'tahun' => $this->tahun,
                'nominal' => $this->nominal,
                'status' => $this->status,
            ]);
            
            // Integrate with Logikraf if Pending
            if ($this->status === 'Pending') {
                $tenantId = tenant('id');
                $invoiceId = "INV-{$tenantId}-{$iuran->id}";
                
                // Get payer email from Warga if exists
                $rumah = Rumah::with('warga')->find($this->id_rumah);
                $payerEmail = optional(optional($rumah->warga->first())->user)->email ?? "warga@{$tenantId}.com";
                $description = "Tagihan Iuran Bulan {$this->bulan} Tahun {$this->tahun}";

                $logikraf = new \App\Services\LogikrafService();
                $invoice = $logikraf->createInvoice($invoiceId, $tenantId, $this->nominal, $payerEmail, $description);

                if ($invoice && isset($invoice['data']['checkout_url'])) {
                    $iuran->update([
                        'external_id' => $invoice['data']['transaction']['external_id'] ?? $invoiceId,
                        'checkout_url' => $invoice['data']['checkout_url']
                    ]);
                }
            }
            
            $this->dispatch('notify', message: 'Tagihan iuran berhasil dibuat');
        }

        $this->dispatch('iuranSaved');
        $this->dispatch('closeModal');
    }

    public function render()
    {
        return view('livewire.tenant.iuran.form', [
            'rumahs' => Rumah::orderBy('nomor_blok')->get()
        ]);
    }
}
