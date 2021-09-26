<?php

namespace App\Http\Controllers\Mechanic;

use App\Http\Controllers\Controller;
use App\Models\Tool;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index(): Renderable
    {
        return view('pages.mechanic.dashboard', [
            'title' => 'Dashboard'
        ]);
    }
}
