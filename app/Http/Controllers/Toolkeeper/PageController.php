<?php

namespace App\Http\Controllers\Toolkeeper;

use App\Http\Controllers\Controller;
use App\Models\Consumable;
use App\Models\RequestConsumable;
use App\Models\RequestTool;
use App\Models\Tool;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class PageController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            if ($request->get('status') == 'tool') {
                $data = RequestTool::where('request_status', 0)->orderBy('created_at', 'DESC');
                return DataTables::of($data->get())
                    ->addIndexColumn()
                    ->addColumn('diff_for_humans', function ($row) {
                        return $row->created_at->diffForHumans();
                    })
                    ->addColumn('serviceman', function ($row) {
                        return $row->user->name . ' <a class="text-muted text-xs d-block" href="' . route('toolkeeper.user.show', $row->user_id) . '">' . $row->user->salary_number . ' </a> ';
                    })
                    ->addColumn('tool', function ($row) {
                        return $row->tool->description . ' <a class="text-muted text-xs d-block" href="' . route('toolkeeper.tool.show', $row->tool_id) . '">Number: ' . $row->tool->part_number . ' </a> ';
                    })
                    ->addColumn('action', function ($row) {
                        return '<form class="d-inline" method="POST" action="' . route('toolkeeper.request.tool.update', $row) . '">
                                    <input type="hidden" name="_method" value="PUT">
                                    <input type="hidden" name="_token" value="' . csrf_token() . '" />
                                    <input type="hidden" name="request_status" value="1">
                                    <button type="button" class="btn btn-success btn-sm btn-block px-2" onclick="justConfirm(this)"> Accept </button>
                                </form>
                                <form class="d-inline" method="POST" action="' . route('toolkeeper.request.tool.update', $row) . '">
                                    <input type="hidden" name="_method" value="PUT">
                                    <input type="hidden" name="_token" value="' . csrf_token() . '" />
                                    <input type="hidden" name="request_status" value="3">
                                    <button type="button" class="btn btn-danger btn-sm btn-block mt-2 px-2" onclick="justConfirm(this)"> Reject </button>
                                </form>';
                    })
                    ->rawColumns(['action', 'tool', 'serviceman'])
                    ->make(true);
            } else {
                $data = RequestConsumable::where('request_status', 0)->orderBy('created_at', 'DESC');
                return DataTables::of($data->get())
                    ->addIndexColumn()
                    ->addColumn('serviceman', function ($row) {
                        return $row->user->name . ' <a class="text-muted text-xs d-block" href="' . route('toolkeeper.user.show', $row->user_id) . '">' . $row->user->salary_number . ' </a> ';
                    })
                    ->addColumn('consumable', function ($row) {
                        return $row->consumable->description . ' <a class="text-muted text-xs d-block" href="' . route('toolkeeper.consumable.show', $row->consumable_id) . '">Number: ' . $row->consumable->consumable_number . ' </a> ';
                    })
                    ->addColumn('action', function ($row) {
                        return '<form class="d-inline" method="POST" action="' . route('toolkeeper.request.consumable.update', $row) . '">
                                    <input type="hidden" name="_method" value="PUT">
                                    <input type="hidden" name="_token" value="' . csrf_token() . '" />
                                    <input type="hidden" name="request_status" value="1">
                                    <button type="button" class="btn btn-success btn-sm btn-block px-2" onclick="justConfirm(this)"> Accept </button>
                                </form>
                                <form class="d-inline" method="POST" action="' . route('toolkeeper.request.consumable.update', $row) . '">
                                    <input type="hidden" name="_method" value="PUT">
                                    <input type="hidden" name="_token" value="' . csrf_token() . '" />
                                    <input type="hidden" name="request_status" value="3">
                                    <button type="button" class="btn btn-danger btn-sm btn-block mt-2 px-2" onclick="justConfirm(this)"> Reject </button>
                                </form>';
                    })
                    ->rawColumns(['action', 'consumable', 'serviceman'])
                    ->make(true);
            }
        }
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
