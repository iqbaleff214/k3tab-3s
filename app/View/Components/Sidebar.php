<?php

namespace App\View\Components;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
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
                    'MASTER DATA',
                    'admin.tool.index' => ['Tools', 'fas fa-tools', 'admin.tool.*'],
                    'admin.consumable.index' => ['Consumables', 'fas fa-box-tissue', 'admin.consumable.*'],
                    'admin.user.index' => ['Users', 'fas fa-users', 'admin.user.*'],
                ];
                break;
            case 'MECHANIC':
                $menus = [
                    'mechanic.dashboard' => ['Dashboard', 'fas fa-home'],
                    '',
                    'mechanic.tool.index' => ['Tools', 'fas fa-tools', 'mechanic.tool.*'],
                    'mechanic.consumable.index' => ['Consumable', 'fas fa-box-tissue', 'mechanic.consumable.*'],
                    'MY REQUEST'
                ];
                break;
            case 'SUPERVISOR':
                $menus = [
                    'supervisor.dashboard' => ['Dashboard', 'fas fa-home'],
                ];
                break;
            case 'TOOLMAN':
                $menus = [
                    'toolman.dashboard' => ['Dashboard', 'fas fa-home'],
                    'MASTER DATA',
                    'toolman.tool.index' => ['Tools', 'fas fa-tools', 'toolman.tool.*'],
                    'toolman.consumable.index' => ['Consumables', 'fas fa-box-tissue', 'toolman.consumable.*'],
                    'REQUEST',
                    'toolman.request.tool.index' => ['Tool Request', 'fas fa-file-alt', 'toolman.request.tool.*'],
                    'toolman.request.consumable.index' => ['Consumable Request', 'far fa-file-alt', 'toolman.request.consumable.*'],
                ];
                break;
        }

        $this->menus = $menus;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return Application|Factory|View
     */
    public function render()
    {
        return view('components.sidebar');
    }
}
