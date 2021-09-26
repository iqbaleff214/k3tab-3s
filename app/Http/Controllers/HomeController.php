<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return RedirectResponse
     */
    public function index(): RedirectResponse
    {
        switch (auth()->user()->role) {
            case 'ADMIN': return \redirect()->route('admin.dashboard');
            case 'SUPERVISOR': return \redirect()->route('supervisor.dashboard');
            case 'TOOLMAN': return \redirect()->route('toolman.dashboard');
            case 'MECHANIC': return \redirect()->route('mechanic.dashboard');
            default:
                Auth::logout();
                return \redirect()->route('login');
        }
    }
}
