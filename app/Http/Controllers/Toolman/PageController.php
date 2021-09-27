<?php

namespace App\Http\Controllers\Toolman;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index(): Renderable
    {
        return view('pages.toolman.dashboard', [
            'title' => 'Dashboard'
        ]);
    }
}
