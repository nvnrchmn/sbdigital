<?php

namespace App\Livewire\Tenant\Polling;

use App\Models\Poll;
use App\Models\PollVote;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Show extends Component
{
    public Poll $poll;
    public $selectedOption = null;

    public function mount(Poll $poll)
    {
        abort_unless(auth()->user()->can('view polling'), 403, 'Akses ditolak.');

        $this->poll = $poll->load(['options', 'votes.warga', 'creator']);
    }

    public function vote()
    {
        $user = Auth::user();

        if (!$user->warga_id) {
            $this->dispatch('notify', message: 'Hanya warga terdaftar yang dapat memberikan suara.', type: 'error');
            return;
        }

        if ($this->poll->status !== 'Aktif') {
            $this->dispatch('notify', message: 'Polling ini sudah ditutup.', type: 'error');
            return;
        }

        if ($this->poll->tgl_selesai && $this->poll->tgl_selesai < now()) {
            $this->dispatch('notify', message: 'Batas waktu polling sudah berakhir.', type: 'error');
            return;
        }

        if (!$this->selectedOption) {
            $this->dispatch('notify', message: 'Pilih salah satu opsi terlebih dahulu.', type: 'error');
            return;
        }

        // Cek apakah sudah vote
        $existingVote = PollVote::where('poll_id', $this->poll->id)
            ->where('warga_id', $user->warga_id)
            ->first();

        if ($existingVote) {
            $this->dispatch('notify', message: 'Anda sudah memberikan suara pada polling ini.', type: 'error');
            return;
        }

        PollVote::create([
            'poll_id' => $this->poll->id,
            'poll_option_id' => $this->selectedOption,
            'warga_id' => $user->warga_id,
        ]);

        $this->poll->refresh();
        $this->dispatch('notify', message: 'Terima kasih, suara Anda telah berhasil disimpan!');
    }

    public function closePolling()
    {
        $user = Auth::user();
        if (!$user->can('manage polling') && !$user->hasRole('Tenant Owner')) {
            abort(403);
        }

        $this->poll->update(['status' => 'Selesai']);
        $this->dispatch('notify', message: 'Polling telah ditutup.');
    }

    public function render()
    {
        $user = Auth::user();
        
        $hasVoted = false;
        $userVote = null;

        if ($user->warga_id) {
            $userVote = PollVote::where('poll_id', $this->poll->id)
                ->where('warga_id', $user->warga_id)
                ->first();
            
            if ($userVote) {
                $hasVoted = true;
            }
        }

        $totalVotes = $this->poll->votes()->count();
        
        $results = [];
        if ($hasVoted || $this->poll->status === 'Selesai' || $this->poll->tgl_selesai && $this->poll->tgl_selesai < now()) {
            foreach ($this->poll->options as $option) {
                $optionVotes = $this->poll->votes()->where('poll_option_id', $option->id)->count();
                $percentage = $totalVotes > 0 ? round(($optionVotes / $totalVotes) * 100, 1) : 0;
                
                $results[] = [
                    'option' => $option,
                    'votes' => $optionVotes,
                    'percentage' => $percentage,
                    'isUserChoice' => $userVote && $userVote->poll_option_id === $option->id
                ];
            }
        }

        $isPengurus = $user->can('manage polling') || $user->hasRole('Tenant Owner');
        $isClosed = $this->poll->status !== 'Aktif' || ($this->poll->tgl_selesai && $this->poll->tgl_selesai < now());

        return view('livewire.tenant.polling.show', [
            'hasVoted' => $hasVoted,
            'totalVotes' => $totalVotes,
            'results' => $results,
            'isPengurus' => $isPengurus,
            'isClosed' => $isClosed,
        ]);
    }
}
