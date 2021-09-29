<?php

namespace App\Http\Controllers\Toolkeeper;

use App\Http\Controllers\Controller;
use App\Models\RequestConsumable;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class RequestConsumableController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = RequestConsumable::where('user_id', '!=', null)->orderBy('created_at', 'DESC');
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
                ->addColumn('serviceman', function ($row) {
                    return $row->user->name . ' <div class="text-muted text-xs">' . $row->user->salary_number . ' </div> ';
                })
                ->addColumn('consumable', function ($row) {
                    return $row->consumable->description . ' <a class="text-muted text-xs d-block" href="' . route('toolkeeper.consumable.show', $row->consumable_id) . '">Number: ' . $row->consumable->consumable_number . ' </a> ';
                })
                ->addColumn('stock', function ($row) {
                    return $row->consumable->quantity . ' ' . $row->consumable->unit;
                })
                ->addColumn('action', function ($row) {
                    $action = '';
                    if ($row->request_status === 0) {
                        $action = '<form class="d-inline" method="POST" action="' . route('toolkeeper.request.consumable.update', $row) . '">
                                        <input type="hidden" name="_method" value="PUT">
                                        <input type="hidden" name="_token" value="' . csrf_token() . '" />
                                        <input type="hidden" name="request_status" value="1">
                                        <button type="button" class="btn btn-success btn-sm px-2" onclick="justConfirm(this)"> Accept </button>
                                    </form>
                                    <form class="d-inline" method="POST" action="' . route('toolkeeper.request.consumable.update', $row) . '">
                                        <input type="hidden" name="_method" value="PUT">
                                        <input type="hidden" name="_token" value="' . csrf_token() . '" />
                                        <input type="hidden" name="request_status" value="3">
                                        <button type="button" class="btn btn-danger btn-sm px-2" onclick="justConfirm(this)"> Reject </button>
                                    </form>';

                    } else {
                        $action = $row->request_status === 1 ? '<span class="badge badge-success">Accepted</span>' : '<span class="badge badge-danger">Rejected</span>';
                    }
                    return $action;
                })
                ->rawColumns(['request_status', 'action', 'created_at', 'consumable', 'serviceman'])
                ->make(true);
        }

        return view('pages.toolkeeper.request.consumable', [
            'title' => 'Consumable Request'
        ]);
    }


    public function update(Request $request, RequestConsumable $consumable)
    {
        try {
            $status_request = $request->input('request_status');
            $quantity = $consumable->consumable->quantity;
            $requested_quantity = $consumable->requested_quantity;
            $accepted_quantity = 0;
            $timestamp = '';

            switch ($status_request) {
                case 1:
                    $message = 'Successfully accepted the request!';
                    $accepted_quantity = $requested_quantity <= $quantity ? $requested_quantity : $quantity;
                    $timestamp = 'accepted_at';
                    break;
                case 3:
                    $message = 'Successfully rejected the request!';
                    $timestamp = 'rejected_at';
                    break;
            }

            $consumable->update(['request_status' => $status_request, $timestamp => Carbon::now(), 'accepted_quantity' => $accepted_quantity ]);

            $consumable->consumable()->update([
                'quantity' => $status_request == 1 ? ($quantity - $accepted_quantity) : $quantity,
            ]);

            return back()->with('success', $message);
        } catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }
}
