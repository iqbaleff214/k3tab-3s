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

    public function data(Request $request): JsonResponse
    {
        $data = Tool::where('equipment_number', '!=', null);
        if ($request->get('q')) {
            $data = $data->where('description', 'like', "%" . $request->get('q') . "%")->orWhere('equipment_number', 'like', "%" . $request->get('q') . "%");
        }
        return response()->json($data->paginate(24));
    }
}
