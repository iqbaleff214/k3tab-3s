<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Sidebar extends Component
{
    public $menus;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $menus = [
            'home' => ['Dashboard', 'fas fa-home']
        ];

        switch (auth()->user()->role) {
            case 'ADMIN':
                $menus = [
                    'admin.dashboard' => ['Dashboard', 'fas fa-home'],
                    'admin.tool.index' => ['Tools', 'fas fa-tools', 'admin.tool.*'],
                    'admin.consumable.index' => ['Consumables', 'fas fa-box-tissue', 'admin.consumable.*'],
                    'admin.user.index' => ['Users', 'fas fa-users', 'admin.user.*'],
                ];
                break;
            case 'MECHANIC':
                $menus = [
                    'mechanic.dashboard' => ['Dashboard', 'fas fa-home'],
                    'mechanic.tool.index' => ['Tools', 'fas fa-tools', 'mechanic.tool.*'],
                ];
        }

        $this->menus = $menus;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.sidebar');
    }
}
