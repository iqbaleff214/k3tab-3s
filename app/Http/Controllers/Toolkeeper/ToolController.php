<?php

namespace App\Http\Controllers\Toolkeeper;

use App\Http\Controllers\Controller;
use App\Models\Tool;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
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
            $data = Tool::where('part_number', '!=', null);
            if (in_array($request->get('status'), [0,1,2]))
                $data->where('equipment_status', $request->get('status'));
            return DataTables::of($data->get())
                ->addIndexColumn()
                ->editColumn('equipment_status', function ($row) {
                    return $row->equipment_status === 1 ? '<span class="badge badge-success">Available</span>' : ($row->equipment_status === 2 ? '<span class="badge badge-warning">Requested</span>' : '<span class="badge badge-danger">Not Available</span>');
                })
                ->addColumn('action', function ($row) {
                    return '<a href="' . route('toolkeeper.tool.show', $row) . '" class="btn btn-sm btn-success">Show</a>
                            <a href="' . route('toolkeeper.tool.edit', $row) . '" class="btn btn-sm btn-primary">Edit</a>';
                })
                ->rawColumns(['action', 'equipment_status'])
                ->make(true);
        }
        return view('pages.toolkeeper.tool.index', [
            'title' => 'Tools'
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
        return view('pages.toolkeeper.tool.show', [
            'title' => 'Show Tool',
            'forms' => $this->form,
            'tool' => $tool
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param Tool $tool
     * @return Renderable
     */
    public function edit(Tool $tool): Renderable
    {
        return view('pages.toolkeeper.tool.edit', [
            'title' => 'Edit Tool',
            'forms' => $this->form,
            'tool' => $tool,
            'opt' => ['Not Available', 'Available', 'Requested']
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Tool $tool
     * @return RedirectResponse
     */
    public function update(Request $request, Tool $tool): RedirectResponse
    {
        $request->validate([
            'part_number' => ['required'],
            'description' => ['required'],
            'equipment_status' => ['required'],
            'equipment_note' => ['required'],
        ]);

        try {
            $tool->update($request->input());
            return back()->with('success', 'Successfully edited the equipment!');
        } catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }
}
