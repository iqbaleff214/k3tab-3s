<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\ConsumablesImport;
use App\Models\Consumable;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

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
     * Display a listing of the resource.
     *
     * @return Renderable
     */
    public function index(): Renderable
    {
        return view('pages.admin.consumable.index', [
            'title' => 'Consumables',
            'items' => Consumable::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Renderable
     */
    public function create(): Renderable
    {
        return view('pages.admin.consumable.create', [
            'title' => 'Add Consumable',
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
            'consumable_number' => ['required', 'unique:consumables,consumable_number'],
            'description' => ['required'],
            'unit' => ['required'],
            'quantity' => ['required', 'min:0', 'integer'],
        ]);

        try {
            Consumable::create($request->input());
            return redirect()->route('admin.consumable.index')->with('success', 'Successfully added consumable!');
        } catch (\Exception $exception) {
            return redirect()->route('admin.consumable.create')->with('error', $exception->getMessage());
        }
    }

    public function import(Request $request): RedirectResponse
    {
        $request->validate([
            'file' => ['required', 'mimes:csv,xls,xlsx,ods', 'max:2048']
        ]);

        try {
            Excel::import(new ConsumablesImport(), \request()->file('file'));
            return redirect()->route('admin.consumable.index')->with('success', 'Successfully imported consumables!');
        } catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Consumable $consumable
     * @return Renderable
     */
    public function show(Consumable $consumable): Renderable
    {
        return view('pages.admin.consumable.show', [
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
        return view('pages.admin.consumable.edit', [
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
        } catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Consumable $consumable
     * @return RedirectResponse
     */
    public function destroy(Consumable $consumable): RedirectResponse
    {
        try {
            $consumable->delete();
            return redirect()->route('admin.consumable.index')->with('success', 'Successfully deleted the consumable!');
        } catch (\Exception $exception) {
            return redirect()->route('admin.consumable.index')->with('error', $exception->getMessage());
        }
    }
}
