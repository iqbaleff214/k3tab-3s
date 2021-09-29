<?php

namespace App\Http\Controllers\Serviceman;

use App\Http\Controllers\Controller;
use App\Models\RequestTool;
use App\Models\Tool;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class PageController extends Controller
{
    public function index(): Renderable
    {
        return view('pages.serviceman.dashboard', [
            'title' => 'Dashboard'
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
}
