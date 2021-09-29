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
            case 'SERVICEMAN':
                $menus = [
                    'serviceman.dashboard' => ['Dashboard', 'fas fa-home'],
                    '',
                    'serviceman.tool.index' => ['Tools', 'fas fa-tools', 'serviceman.tool.*'],
                    'serviceman.consumable.index' => ['Consumable', 'fas fa-box-tissue', 'serviceman.consumable.*'],
                    'MY REQUEST'
                ];
                break;
            case 'SUPERVISOR':
                $menus = [
                    'supervisor.dashboard' => ['Dashboard', 'fas fa-home'],
                ];
                break;
            case 'TOOLKEEPER':
                $menus = [
                    'toolkeeper.dashboard' => ['Dashboard', 'fas fa-home'],
                    'MASTER DATA',
                    'toolkeeper.tool.index' => ['Tools', 'fas fa-tools', 'toolkeeper.tool.*'],
                    'toolkeeper.consumable.index' => ['Consumables', 'fas fa-box-tissue', 'toolkeeper.consumable.*'],
                    'toolkeeper.user.index' => ['Servicemen', 'fas fa-users', 'toolkeeper.user.*'],
                    'REQUEST',
                    'toolkeeper.request.tool.index' => ['Tool Request', 'fas fa-file-alt', 'toolkeeper.request.tool.*'],
                    'toolkeeper.request.consumable.index' => ['Consumable Request', 'far fa-file-alt', 'toolkeeper.request.consumable.*'],
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
