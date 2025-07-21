<?php

namespace App\Livewire;

use Livewire\Component;
use app\Models\Menu;
use Pest\Collision\Events;

class HomePage extends Component
{
    public $items;

    public function mount()
    {
        $this->items = Menu::all();
    }

    public function render()
{
    return view('livewire.home-page', [
        'menus' => Menu::all(),
    ]);
}

}

