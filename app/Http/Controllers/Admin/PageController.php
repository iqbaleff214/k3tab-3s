<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Consumable;
use App\Models\Tool;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;

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

    public function truncate()
    {
        try {
            Artisan::call('migrate:fresh --seed');
            Auth::logout();
            return back()->with('success', 'Successfully truncated the data!');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }
}
