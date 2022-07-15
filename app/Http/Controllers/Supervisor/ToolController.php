<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use App\Models\Tool;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ToolController extends Controller
{
    private $form = [
        'part_number' => 'text',
        'tech_ident_number' => 'text',
        'equipment_status' => 'text',
        'equipment_note' => 'text',
        'business_area' => 'text',
        'maintenance_plant' => 'text',
        'material' => 'text',
        'manufacturer' => 'text',
        'description' => 'text',
        'additional_description' => 'text',
        'size' => 'text',
        'manufacture_serial_number' => 'text',
        'asset' => 'text',
        'location' => 'text',
        'license_number' => 'text',
        'system_status' => 'text',
        'user_status' => 'text',
        'sort_field' => 'text',
        'equipment_category' => 'text',
        'currency' => 'text',
        'acquisition_value' => 'text',
        'startup_date' => 'date',
        'changed_by' => 'text',
        'created_by' => 'text',
        'abc_indicator' => 'text',
        'acquisition_date' => 'date',
    ];

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(Tool::all())
                ->addIndexColumn()
                ->editColumn('equipment_status', function($row) {
                    return $row->equipment_status == 1 ? '<span class="badge badge-success">Available</span>' : '<span class="badge badge-danger">Not Available</span>';
                })
                ->addColumn('action', function($row) {
                    return '<a href="' . route('supervisor.tool.show', $row) . '" class="btn btn-sm btn-success">Show</a>';
                })
                ->rawColumns(['action', 'equipment_status'])
                ->make(true);
        }
        return view('pages.supervisor.tool.index', [
            'title' => 'Tools',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param Tool $tool
     * @return Renderable
     */
    public function show(Tool $tool): Renderable
    {
        return view('pages.supervisor.tool.show', [
            'title' => 'Show Tool',
            'forms' => $this->form,
            'tool' => $tool
        ]);
    }
}
