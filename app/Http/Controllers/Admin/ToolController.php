<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\ToolsImport;
use App\Models\Tool;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class ToolController extends Controller
{

    private $form = [
        'part_number' => 'text',
        'tech_ident_number' => 'text',
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

    /**
     * @throws Exception
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(Tool::all())
                ->addIndexColumn()
                ->editColumn('equipment_status', function($row) {
                    return $row->equipment_status == 1 ? '<span class="badge badge-success">Available</span>' : '<span class="badge badge-danger">Not Available</span>';
                })
                ->addColumn('action', function($row) {
                    return '<a href="' . route('admin.tool.show', $row) . '" class="btn btn-sm btn-success">Show</a>
                            <a href="' . route('admin.tool.edit', $row) . '" class="btn btn-sm btn-primary">Edit</a>
                            <form action="' . route('admin.tool.destroy', $row) . '" method="POST" class="d-inline">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="_token" value="'.csrf_token().'" />
                                <a href="#" class="btn btn-sm btn-danger" onclick="event.preventDefault(); deleteConfirm(this)">Delete</a>
                            </form>';
                })
                ->rawColumns(['action', 'equipment_status'])
                ->make(true);
        }
        return view('pages.admin.tool.index', [
            'title' => 'Tools',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Renderable
     */
    public function create(): Renderable
    {
        return view('pages.admin.tool.create', [
            'title' => 'Add Tool',
            'forms' => $this->form
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'part_number' => ['required', /*'unique:tools,part_number',*/],
            'description' => ['required'],
        ]);

        try {
            Tool::create($request->input());
            return redirect()->route('admin.tool.index')->with('success', 'Successfully added equipment!');
        } catch (Exception $exception) {
            return redirect()->route('admin.tool.create')->with('error', $exception->getMessage());
        }
    }

    public function import(Request $request): RedirectResponse
    {
        $request->validate([
            'file' => ['required', 'mimes:csv,xls,xlsx,ods', 'max:2048']
        ]);

        try {
            Excel::import(new ToolsImport(), \request()->file('file'));
            return redirect()->route('admin.tool.index')->with('success', 'Successfully imported equipments!');
        } catch (Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\tool  $tool
     * @return Renderable
     */
    public function show(tool $tool): Renderable
    {
        return view('pages.admin.tool.show', [
            'title' => 'Show Tool',
            'forms' => $this->form,
            'tool' => $tool
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\tool  $tool
     * @return Renderable
     */
    public function edit(tool $tool): Renderable
    {
        return view('pages.admin.tool.edit', [
            'title' => 'Edit Tool',
            'forms' => $this->form,
            'tool' => $tool
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  \App\Models\tool  $tool
     * @return RedirectResponse
     */
    public function update(Request $request, tool $tool): RedirectResponse
    {
        $request->validate([
            'part_number' => ['required', Rule::unique('tools')->ignore($tool), 'integer'],
            'description' => ['required'],
        ]);

        try {
            $tool->update($request->input());
            return back()->with('success', 'Successfully edited the equipment!');
        } catch (Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\tool  $tool
     * @return RedirectResponse
     */
    public function destroy(tool $tool): RedirectResponse
    {
        try {
            $tool->delete();
            return redirect()->route('admin.tool.index')->with('success', 'Successfully deleted the equipment!');
        } catch (Exception $exception) {
            return redirect()->route('admin.tool.index')->with('error', $exception->getMessage());
        }
    }
}
