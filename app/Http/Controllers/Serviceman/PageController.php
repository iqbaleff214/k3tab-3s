<?php

namespace App\Http\Controllers\Serviceman;

use App\Http\Controllers\Controller;
use App\Models\Consumable;
use App\Models\RequestConsumable;
use App\Models\RequestTool;
use App\Models\Tool;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class PageController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(RequestTool::whereIn('request_status', [0,1])->where('user_id', auth()->user()->id)->get())
                ->addIndexColumn()
                ->addColumn('diff_for_humans', function ($row) {
                    return $row->created_at->diffForHumans();
                })
                ->addColumn('tool', function ($row) {
                    return $row->tool->description . ' <a class="text-muted text-xs d-block" href="' . route('serviceman.tool.show', $row->tool_id) . '">Number: ' . $row->tool->part_number . ' </a> ';
                })
                ->editColumn('request_status', function ($row) {
                    $status = '';
                    // 0: Requested
                    // 1: Borrowed
                    // 2: Returned
                    // 3: Rejected
                    switch ($row->request_status) {
                        case 0:
                            $status = '<span class="badge badge-warning">Requested</span>';
                            break;
                        case 1:
                            $status = '<span class="badge badge-primary">Borrowed</span>';
                            break;
                        case 2:
                            $status = '<span class="badge badge-success">Returned</span>';
                            break;
                        case 3:
                            $status = '<span class="badge badge-danger">Rejected</span>';
                            break;
                    }
                    return $status;
                })
                ->editColumn('requested_at', function ($row) {
                    return Carbon::parse($row->requested_at)->format('d-m-Y H:m') . ' <div class="text-muted text-xs"> ' . Carbon::parse($row->requested_at)->diffForHumans() . ' </div> ';
                })
                ->rawColumns(['tool', 'request_status', 'requested_at'])
                ->make(true);
        }
        return view('pages.serviceman.dashboard', [
            'title' => 'Dashboard',
            'count' => [
                'tools' => Tool::where('equipment_status', 1)->count(),
                'consumables' => Consumable::where('quantity', '>', 0)->count(),
                'tool_request' => RequestTool::where('request_status', 0)->where('user_id', auth()->user()->id)->count(),
                'consumable_request' => RequestConsumable::where('request_status', 0)->where('user_id', auth()->user()->id)->count(),
            ],
        ]);
    }

    public function request_tool(Request $request)
    {
        if ($request->ajax()) {
            $data = RequestTool::where('user_id', auth()->user()->id)->orderBy('created_at', 'DESC');
            if (in_array($request->get('status'), [0, 1, 2, 3]))
                $data->where('request_status', $request->get('status'));
            return DataTables::of($data->get())
                ->addIndexColumn()
                ->editColumn('created_at', function ($row) {
                    return $row->created_at->isoFormat('DD-MM-Y HH:mm') . ' <div class="text-muted text-xs"> ' . $row->created_at->diffForHumans() . ' </div> ';
                })
                ->editColumn('requested_at', function ($row) {
                    return Carbon::parse($row->requested_at)->format('d-m-Y H:m') . ' <div class="text-muted text-xs"> ' . Carbon::parse($row->requested_at)->diffForHumans() . ' </div> ';
                })
                ->editColumn('returned_at', function ($row) {
                    if ($row->returned_at)
                        return Carbon::parse($row->returned_at)->format('d-m-Y H:m') . ' <div class="text-muted text-xs"> ' . Carbon::parse($row->returned_at)->diffForHumans() . ' </div> ';
                    else
                        return '-';
                })
                ->editColumn('request_status', function ($row) {
                    $status = '';
                    // 0: Requested
                    // 1: Borrowed
                    // 2: Returned
                    // 3: Rejected
                    switch ($row->request_status) {
                        case 0:
                            $status = '<span class="badge badge-warning">Requested</span>';
                            break;
                        case 1:
                            $status = '<span class="badge badge-primary">Borrowed</span>';
                            break;
                        case 2:
                            $status = '<span class="badge badge-success">Returned</span>';
                            break;
                        case 3:
                            $status = '<span class="badge badge-danger">Rejected</span>';
                            break;
                    }
                    return $status;
                })
                ->addColumn('diff_for_humans', function ($row) {
                    return $row->created_at->diffForHumans();
                })
                ->addColumn('tool', function ($row) {
                    return $row->tool->description . ' <a class="text-muted text-xs d-block" href="' . route('toolkeeper.tool.show', $row->tool_id) . '">Number: ' . $row->tool->part_number . ' </a> ';
                })
                ->rawColumns(['request_status', 'requested_at', 'returned_at', 'tool',])
                ->make(true);
        }

        return view('pages.serviceman.tool.request', [
            'title' => 'Tool Request'
        ]);
    }

    public function request_consumable(Request $request)
    {
        if ($request->ajax()) {
            $data = RequestConsumable::where('user_id', auth()->user()->id)->orderBy('created_at', 'DESC');
            if (in_array($request->get('status'), [0,1,3]))
                $data->where('request_status', $request->get('status'));
            return DataTables::of($data->get())
                ->addIndexColumn()
                ->editColumn('created_at', function ($row) {
                    return $row->created_at->isoFormat('DD-MM-Y HH:mm') . ' <div class="text-muted text-xs"> ' . $row->created_at->diffForHumans() . ' </div> ';
                })
                ->editColumn('request_status', function ($row) {
                    $status = '';
                    // 0: Requested
                    // 1: Accepted
                    // 2: -
                    // 3: Rejected
                    switch ($row->request_status) {
                        case 0:
                            $status = '<span class="badge badge-primary">Requested</span>';
                            break;
                        case 1:
                            $status = '<span class="badge badge-success">Accepted</span>';
                            break;
                        case 3:
                            $status = '<span class="badge badge-danger">Rejected</span>';
                            break;
                    }
                    return $status;
                })
                ->editColumn('requested_quantity', function ($row) {
                    return $row->requested_quantity . ' ' . $row->consumable->unit;
                })->editColumn('accepted_quantity', function ($row) {
                    return ($row->accepted_quantity ?? 0) . ' ' . $row->consumable->unit;
                })
                ->addColumn('consumable', function ($row) {
                    return $row->consumable->description . ' <a class="text-muted text-xs d-block" href="' . route('toolkeeper.consumable.show', $row->consumable_id) . '">Number: ' . $row->consumable->consumable_number . ' </a> ';
                })
                ->addColumn('stock', function ($row) {
                    return $row->consumable->quantity . ' ' . $row->consumable->unit;
                })
                ->rawColumns(['request_status', 'created_at', 'consumable'])
                ->make(true);
        }

        return view('pages.serviceman.consumable.request', [
            'title' => 'Consumable Request'
        ]);
    }
}
