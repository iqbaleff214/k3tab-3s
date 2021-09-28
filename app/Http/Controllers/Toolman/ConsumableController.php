<?php

namespace App\Http\Controllers\Toolman;

use App\Http\Controllers\Controller;
use App\Models\Consumable;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
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
                    return '<a href="' . route('toolman.consumable.show', $row) . '" class="btn btn-sm btn-success">Show</a>
                            <a href="' . route('toolman.consumable.edit', $row) . '" class="btn btn-sm btn-primary">Edit</a>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('pages.toolman.consumable.index', [
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
        return view('pages.toolman.consumable.show', [
            'title' => 'Show Consumable',
            'forms' => $this->form,
            'consumable' => $consumable
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Consumable $consumable
     * @return Renderable
     */
    public function edit(Consumable $consumable): Renderable
    {
        return view('pages.toolman.consumable.edit', [
            'title' => 'Edit Consumable',
            'forms' => $this->form,
            'consumable' => $consumable
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Consumable $consumable
     * @return RedirectResponse
     */
    public function update(Request $request, Consumable $consumable): RedirectResponse
    {
        $request->validate([
            'consumable_number' => ['required', Rule::unique('consumables')->ignore($consumable)],
            'description' => ['required'],
            'unit' => ['required'],
            'quantity' => ['required', 'min:0', 'integer'],
        ]);

        try {
            $consumable->update($request->input());
            return back()->with('success', 'Successfully edited the consumable!');
        } catch (Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }
}
