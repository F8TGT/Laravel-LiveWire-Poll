<?php

namespace App\Livewire;

use App\Models\Poll;
use Illuminate\View\View;
use Livewire\Attributes\Validate;
use Livewire\Component;

class CreatePoll extends Component
{
    #[Validate('required|min:3|max:255')]
    public $title;

    #[Validate([
        'options' =>'required|array|min:1|max:10',
        'options.*' => 'required|min:3|max:255',
    ], message: [
        'options.*.required' => 'The option can\'t be empty.',
        'options.*.min' => 'The option field must be at least 3 characters.',
        'options.*.max' => 'The option field must not be greater than 255 characters.',
    ])]

    public $options = ['First'];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    protected $messages = [
        'options.*.required' => 'The option can\'t be empty.',
    ];

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

    public function createPoll()
    {
        $this->validate();

        Poll::create([
            'title' => $this->title,
        ])->options()->createMany(
            collect($this->options)->map(fn($option) => ['name' => $option])->all(),
        );

        $this->reset(['title', 'options']);
    }
}
