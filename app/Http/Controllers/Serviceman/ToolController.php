<?php

namespace App\Http\Controllers\Serviceman;

use App\Http\Controllers\Controller;
use App\Models\RequestTool;
use App\Models\Tool;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ToolController extends Controller
{

    public function index(): Renderable
    {
        return view('pages.serviceman.tool.index', [
            'title' => 'Tools'
        ]);
    }

    public function show(Tool $tool): Renderable
    {
        return view('pages.serviceman.tool.show', [
            'title' => 'Show Tool',
            'forms' => [
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
            ],
            'tool' => $tool
        ]);
    }

    public function data(Request $request): JsonResponse
    {
        $data = Tool::where('part_number', '!=', null);
        if ($request->get('status') !== null) {
            $data = $data->where('equipment_status', $request->get('status'));
        }
        if ($request->get('q')) {
            $data = $data->where('description', 'like', "%" . $request->get('q') . "%")->orWhere('part_number', 'like', "%" . $request->get('q') . "%");
        }
        return response()->json($data->paginate(9));
    }

    public function order(Request $request, Tool $tool)
    {
        if ($tool->equipment_status !== 1) {
            return back()->with('info', 'The equipment not available right now!');
        }

        try {
            RequestTool::create([
                'user_id' => auth()->user()->id,
                'tool_id' => $tool->id,
                'requested_at' => Carbon::now()
            ]);

            $tool->update(['equipment_status' => 2, 'equipment_note' => 'Requested by ' . auth()->user()->name]);

            return back()->with('success', 'Successfully requested the equipment!');

        } catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }
}
