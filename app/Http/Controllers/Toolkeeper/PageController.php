<?php

namespace App\Http\Controllers\Toolkeeper;

use App\Http\Controllers\Controller;
use App\Models\Consumable;
use App\Models\RequestConsumable;
use App\Models\RequestTool;
use App\Models\Tool;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index(): Renderable
    {
        return view('pages.toolkeeper.dashboard', [
            'title' => 'Dashboard',
            'count' => [
                'tools' => Tool::count(),
                'consumables' => Consumable::count(),
                'tool_request' => RequestTool::where('request_status', 0)->count(),
                'consumable_request' => RequestConsumable::where('request_status', 0)->count(),
            ],
        ]);
    }
}
