<?php

namespace App\Http\Controllers\Toolkeeper;

use App\Exports\RequestToolExport;
use App\Http\Controllers\Controller;
use App\Models\RequestTool;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class RequestToolController extends Controller
{
    public function index(Request $request)
    {
        // dd(RequestTool::selectRaw('request_tools.created_at, CASE WHEN request_tools.request_status = 0 THEN "Requested" WHEN request_tools.request_status = 1 THEN "Borrowed" WHEN request_tools.request_status = 2 THEN "Returned" WHEN request_tools.request_status = 3 THEN "Rejected" ELSE "Unknown" END as status, users.name, users.salary_number, tools.description, tools.part_number')->join('users', 'users.id', '=', 'request_tools.user_id')->join('tools', 'tools.id', '=', 'request_tools.tool_id')->oldest()->get());
        if ($request->ajax()) {
            $data = RequestTool::where('user_id', '!=', null)->orderBy('created_at', 'DESC');
            if (in_array($request->get('status'), [0,1,2,3]))
                $data->where('request_status', $request->get('status'));
            return DataTables::of($data->get())
                ->addIndexColumn()
                ->editColumn('created_at', function ($row) {
                    return $row->created_at->isoFormat('DD-MM-Y HH:mm') . ' <div class="text-muted text-xs"> ' . $row->created_at->diffForHumans() . ' </div> ';
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
                ->addColumn('serviceman', function ($row) {
                    return $row->user->name . ' <a class="text-muted text-xs d-block" href="' . route('toolkeeper.user.show', $row->user_id) . '">' . $row->user->salary_number . ' </a> ';
                })
                ->addColumn('tool', function ($row) {
                    return $row->tool->description . ' <a class="text-muted text-xs d-block" href="' . route('toolkeeper.tool.show', $row->tool_id) . '">Number: ' . $row->tool->part_number . ' </a> ';
                })
                ->addColumn('action', function ($row) {
                    $action = '';
                    switch ($row->request_status) {
                        case 0:
                            $action = '<form class="d-inline" method="POST" action="' . route('toolkeeper.request.tool.update', $row) . '">
                                            <input type="hidden" name="_method" value="PUT">
                                            <input type="hidden" name="_token" value="' . csrf_token() . '" />
                                            <input type="hidden" name="request_status" value="1">
                                            <button type="button" class="btn btn-success btn-sm px-2" onclick="justConfirm(this)"> Accept </button>
                                        </form>
                                        <form class="d-inline" method="POST" action="' . route('toolkeeper.request.tool.update', $row) . '">
                                            <input type="hidden" name="_method" value="PUT">
                                            <input type="hidden" name="_token" value="' . csrf_token() . '" />
                                            <input type="hidden" name="request_status" value="3">
                                            <button type="button" class="btn btn-danger btn-sm px-2" onclick="justConfirm(this)"> Reject </button>
                                        </form>';
                            break;
                        case 1:
                            $action = '<form class="d-inline" method="POST" action="' . route('toolkeeper.request.tool.update', $row) . '">
                                            <input type="hidden" name="_method" value="PUT">
                                            <input type="hidden" name="_token" value="' . csrf_token() . '" />
                                            <input type="hidden" name="request_status" value="2">
                                            <button type="button" class="btn btn-primary btn-sm btn-block px-2" onclick="justConfirm(this)"> Returned </button>
                                        </form>';
                            break;
                    }
                    return $action;
                })
                ->rawColumns(['request_status', 'action', 'created_at', 'tool', 'serviceman'])
                ->make(true);
        }

        return view('pages.toolkeeper.request.tool', [
            'title' => 'Tool Request'
        ]);
    }

    public function update(Request $request, RequestTool $tool): RedirectResponse
    {
        try {
            $status_request = $request->input('request_status');
            $note = '';
            $message = '';
            $timestamp = '';

            switch ($status_request) {
                case 1:
                    $note = str_replace('Requested', 'Brought', $tool->tool->equipment_note);
                    $message = 'Successfully accepted the request!';
                    $timestamp = 'borrowed_at';
                    break;
                case 2:
                    $note = str_replace('Brought', 'Returned', $tool->tool->equipment_note);
                    $message = 'Successfully returned the borrowed tool!';
                    $timestamp = 'returned_at';
                    break;
                case 3:
                    $note = 'Previous request has been rejected';
                    $message = 'Successfully rejected the request!';
                    $timestamp = 'rejected_at';
                    break;
            }

            $tool->update(['request_status' => $status_request, $timestamp => Carbon::now()]);

            $tool->tool()->update([
                'equipment_status' => $status_request == 1 ? false : 1,
                'equipment_note' => $note
            ]);

            return back()->with('success', $message);
        } catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    public function export(Request $request)
    {
        try {
            $since = $request->get('tool-request-report-since');
            $until = $request->get('tool-request-report-until');
            $filename = time() . '_' . $since . '_-_' . $until . '-request-tool-report.xlsx';

            return Excel::download(new RequestToolExport(Carbon::parse($since), Carbon::parse($until)->addDay()), $filename);
        } catch (Exception $exception) {
            dd($exception->getMessage());
            return back()->with('error', $exception->getMessage());
        }
    }
}
