<?php

namespace App\Livewire\Central\Announcement;

use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        $announcements = \App\Models\GlobalAnnouncement::latest()->get();

        return view('livewire.central.announcement.index', compact('announcements'))
            ->layout('layouts.superadmin');
    }
}
