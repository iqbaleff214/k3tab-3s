<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Consumable;
use App\Models\Tool;
use App\Models\User;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index()
    {
        return view('pages.admin.dashboard', [
            'title' => 'Dashboard',
            'count' => [
                'tools' => Tool::count(),
                'consumables' => Consumable::count(),
                'users' => User::where('role', 'SERVICEMAN')->count(),
            ],
        ]);
    }
}
