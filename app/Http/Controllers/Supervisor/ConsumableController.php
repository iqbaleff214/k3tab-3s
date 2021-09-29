<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use App\Models\Consumable;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ConsumableController extends Controller
{
    private $form = [
        'consumable_number' => 'text',
        'description' => 'text',
        'additional_description' => 'text',
        'unit' => 'text',
        'quantity' => 'number',
    ];
    /**
     * @throws Exception
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(Consumable::all())
                ->addIndexColumn()
                ->addColumn('action', function($row) {
                    return '<a href="' . route('supervisor.consumable.show', $row) . '" class="btn btn-sm btn-success">Show</a>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('pages.supervisor.consumable.index', [
            'title' => 'Consumables',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param Consumable $consumable
     * @return Renderable
     */
    public function show(Consumable $consumable): Renderable
    {
        return view('pages.supervisor.consumable.show', [
            'title' => 'Show Consumable',
            'forms' => $this->form,
            'consumable' => $consumable
        ]);
    }
}
