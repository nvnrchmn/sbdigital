<?php

namespace App\Livewire\Tenant\Polling;

use App\Models\Poll;
use App\Models\PollOption;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Support\TenantPermissions;

class Form extends Component
{
    public $poll = null;
    public $judul = '';
    public $deskripsi = '';
    public $tgl_selesai = '';
    public $opsi = ['', '']; // Minimal 2 opsi awal

    public function mount($poll = null)
    {
        $user = Auth::user();
        if (!TenantPermissions::hasAnyRoleOrPermission($user, TenantPermissions::POLLING, 'manage polling')) {
            abort(403, 'Anda tidak memiliki akses mengelola polling.');
        }

        if ($poll) {
            $poll = $poll instanceof Poll ? $poll : Poll::with('options')->findOrFail($poll);
            $this->poll = $poll;
            $this->judul = $poll->judul;
            $this->deskripsi = $poll->deskripsi;
            $this->tgl_selesai = $poll->tgl_selesai ? $poll->tgl_selesai->format('Y-m-d\TH:i') : '';
            
            if ($poll->options->count() > 0) {
                $this->opsi = $poll->options->pluck('teks')->toArray();
            }
        }
    }

    public function addOpsi()
    {
        $this->opsi[] = '';
    }

    public function removeOpsi($index)
    {
        if (count($this->opsi) > 2) {
            unset($this->opsi[$index]);
            $this->opsi = array_values($this->opsi);
        }
    }

    public function save()
    {
        $user = Auth::user();
        if (!TenantPermissions::hasAnyRoleOrPermission($user, TenantPermissions::POLLING, 'manage polling')) {
            abort(403, 'Akses ditolak.');
        }

        $this->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string|max:1000',
            'tgl_selesai' => 'nullable|date',
            'opsi' => 'required|array|min:2',
            'opsi.*' => 'required|string|max:255',
        ], [
            'opsi.*.required' => 'Setiap opsi pilihan harus diisi.',
            'opsi.min' => 'Polling minimal harus memiliki 2 opsi pilihan.'
        ]);

        $data = [
            'judul' => $this->judul,
            'deskripsi' => $this->deskripsi,
            'tgl_selesai' => $this->tgl_selesai ?: null,
        ];

        if ($this->poll) {
            $hasVotes = $this->poll->votes()->exists();
            $currentOptions = $this->poll->options()->orderBy('id')->pluck('teks')->values()->all();

            if ($hasVotes && $currentOptions !== array_values($this->opsi)) {
                $this->addError('opsi', 'Opsi polling tidak dapat diubah karena sudah ada warga yang memberikan suara. Buat polling baru jika pilihan harus berubah.');
                return;
            }

            $this->poll->update($data);
            $poll = $this->poll;

            if (!$hasVotes) {
                $poll->options()->delete();

                foreach ($this->opsi as $teks) {
                    PollOption::create([
                        'poll_id' => $poll->id,
                        'teks' => $teks,
                    ]);
                }
            }

            $message = 'Polling berhasil diperbarui';
        } else {
            $data['created_by'] = $user->id;
            $data['status'] = 'Aktif';
            $poll = Poll::create($data);
            $message = 'Polling baru berhasil dibuat';
        }

        if (!$this->poll) {
            foreach ($this->opsi as $teks) {
                PollOption::create([
                    'poll_id' => $poll->id,
                    'teks' => $teks,
                ]);
            }
        }

        $this->dispatch('notify', message: $message);
        $this->dispatch('pollSaved');
        $this->dispatch('close-modal');
    }

    public function render()
    {
        return view('livewire.tenant.polling.form');
    }
}
