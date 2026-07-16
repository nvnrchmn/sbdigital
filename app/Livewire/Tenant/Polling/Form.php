<?php

namespace App\Livewire\Tenant\Polling;

use App\Models\Poll;
use App\Models\PollOption;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Form extends Component
{
    public ?Poll $poll = null;
    public $judul = '';
    public $deskripsi = '';
    public $tgl_selesai = '';
    public $opsi = ['', '']; // Minimal 2 opsi awal

    public function mount(Poll $poll = null)
    {
        $user = Auth::user();
        if (!$user->can('manage polling') && !$user->hasRole('Tenant Owner')) {
            abort(403, 'Anda tidak memiliki akses mengelola polling.');
        }

        if ($poll && $poll->exists) {
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
        if (!$user->can('manage polling') && !$user->hasRole('Tenant Owner')) {
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
            $this->poll->update($data);
            
            // Hapus opsi lama, buat yang baru (agar simpel)
            $this->poll->options()->delete();
            $poll = $this->poll;
            $message = 'Polling berhasil diperbarui';
        } else {
            $data['created_by'] = $user->id;
            $data['status'] = 'Aktif';
            $poll = Poll::create($data);
            $message = 'Polling baru berhasil dibuat';
        }

        foreach ($this->opsi as $teks) {
            PollOption::create([
                'poll_id' => $poll->id,
                'teks' => $teks,
            ]);
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
