<?php

namespace App\Livewire\Tenant\Polling;

use App\Models\Poll;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $filterStatus = '';

    protected $listeners = ['pollSaved' => '$refresh'];

    public function delete(Poll $poll)
    {
        $user = Auth::user();
        if (!$user->can('manage polling') && !$user->hasRole('Tenant Owner')) {
            abort(403, 'Akses ditolak.');
        }

        $poll->delete();
        $this->dispatch('notify', message: 'Polling berhasil dihapus');
    }

    public function render()
    {
        $user = Auth::user();
        $isPengurus = $user->can('manage polling') || $user->hasRole('Tenant Owner');

        $query = Poll::withCount('votes')
            ->where(function($q) {
                $q->where('judul', 'like', '%' . $this->search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $this->search . '%');
            })
            ->when($this->filterStatus, function($q) {
                $q->where('status', $this->filterStatus);
            });

        $polls = $query->orderBy('status', 'asc')->orderBy('created_at', 'desc')->paginate(12);

        // Cari tahu polling mana saja yang sudah dipilih oleh user
        $votedPollIds = collect();
        if ($user->warga_id) {
            $votedPollIds = \App\Models\PollVote::where('warga_id', $user->warga_id)
                ->whereIn('poll_id', $polls->pluck('id'))
                ->pluck('poll_id');
        }

        return view('livewire.tenant.polling.index', [
            'polls' => $polls,
            'votedPollIds' => $votedPollIds,
            'isPengurus' => $isPengurus,
        ]);
    }
}
