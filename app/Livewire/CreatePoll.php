<?php

namespace App\Livewire;

use Illuminate\View\View;
use Livewire\Component;

class CreatePoll extends Component
{
    public $title;
    public $options = ['First'];

    public function render(): View
    {
        return view('livewire.create-poll');
    }

    public function addOption()
    {
        $this->options[] = '';
    }

    public function removeOption($index)
    {
        unset($this->options[$index]);
        $this->options = array_values($this->options);
    }
}
