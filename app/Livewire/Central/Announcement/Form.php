<?php

namespace App\Livewire\Central\Announcement;

use Livewire\Component;

class Form extends Component
{
    public ?\App\Models\GlobalAnnouncement $announcement = null;
    public $title;
    public $content;
    public $is_active = true;

    public function mount(?\App\Models\GlobalAnnouncement $announcement = null)
    {
        abort_unless(auth()->user()->hasRole('Super Admin'), 403, 'Akses ditolak.');

        if ($announcement && $announcement->exists) {
            $this->announcement = $announcement;
            $this->title = $announcement->title;
            $this->content = $announcement->content;
            $this->is_active = $announcement->is_active;
        }
    }

    public function save()
    {
        abort_unless(auth()->user()->hasRole('Super Admin'), 403, 'Akses ditolak.');

        $this->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'is_active' => 'boolean',
        ]);

        if (!$this->announcement) {
            \App\Models\GlobalAnnouncement::create([
                'title' => $this->title,
                'content' => $this->content,
                'is_active' => $this->is_active,
            ]);
        } else {
            $this->announcement->update([
                'title' => $this->title,
                'content' => $this->content,
                'is_active' => $this->is_active,
            ]);
        }

        return redirect()->route('superadmin.announcements.index');
    }

    public function render()
    {
        return view('livewire.central.announcement.form')
            ->layout('layouts.superadmin');
    }
}
