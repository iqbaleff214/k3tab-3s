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
            case 'TOOLKEEPER': return \redirect()->route('toolkeeper.dashboard');
            case 'SERVICEMAN': return \redirect()->route('serviceman.dashboard');
            default:
                Auth::logout();
                return \redirect()->route('login');
        }
    }

    public function about()
    {
        return view('pages.general.about', [
            'title' => 'About',
            'guide' => 'https://filebin.net/l23569zyio4yvz1n/CARA_PENGGUNAAN_3S.pdf'
        ]);
    }
}
