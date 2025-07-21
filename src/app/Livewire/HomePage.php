<?php

namespace App\Livewire;

use Livewire\Component;
use app\Models\Menu;

class HomePage extends Component
{
    public $items;

    public function mount()
    {
        $this->items = Menu::all();
    }

    public function render()
    {
        return view('livewire.home-page');
    }
}

