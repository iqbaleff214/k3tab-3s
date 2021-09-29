<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use App\Models\Consumable;
use App\Models\Tool;
use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index(): Renderable
    {
        return view('pages.supervisor.dashboard', [
            'title' => 'Dashboard',
            'count' => [
                'tools' => Tool::count(),
                'consumables' => Consumable::count(),
                'users' => User::where('role', 'SERVICEMAN')->count(),
            ],
        ]);
    }
}
