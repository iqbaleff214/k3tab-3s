<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(User::where('role', 'SERVICEMAN')->get())
                ->addIndexColumn()
                ->editColumn('salary_number', function ($row) {
                    return $row->salary_number ?? '-';
                })
                ->addColumn('action', function ($row) {
                    return '<a href="' . route('supervisor.user.show', $row) . '" class="btn btn-sm btn-success">Show</a>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('pages.supervisor.user.index', [
            'title' => 'Servicemen'
        ]);
    }

    public function show(Request $request, User $user)
    {
        if ($request->ajax()) {
            $data = $user->tool_request()->orderByDesc('created_at');
            return DataTables::of($data->get())
                ->addIndexColumn()
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
                ->addColumn('tool', function ($row) {
                    return $row->tool->description . ' <a class="text-muted text-xs d-block" href="' . route('supervisor.tool.show', $row->tool_id) . '">Number: ' . $row->tool->part_number . ' </a> ';
                })
                ->rawColumns(['request_status', 'requested_at', 'tool', 'returned_at'])
                ->make(true);
        }
        return view('pages.supervisor.user.show', [
            'title' => 'Show Serviceman',
            'user' => $user,
            'forms' => [
                'salary_number' => 'text',
                'name' => 'text',
                'email' => 'email',
                'address' => 'text',
                'phone_number' => 'text',
            ],
        ]);
    }
}
