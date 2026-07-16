<?php

namespace App\Livewire;

use Livewire\Attributes\On;
use Livewire\Component;

class DynamicModal extends Component
{
    public bool $show = false;

    public ?string $activeComponent = null;

    public array $arguments = [];

    #[On('open-modal')]
    #[On('openModal')]
    public function openModal(string $component, array $arguments = [])
    {
        $this->activeComponent = $component;
        $this->arguments = $arguments;
        $this->show = true;
    }

    #[On('close-modal')]
    #[On('closeModal')]
    public function closeModal()
    {
        $this->show = false;
        $this->activeComponent = null;
        $this->arguments = [];
    }

    public function render()
    {
        return view('livewire.dynamic-modal');
    }
}
