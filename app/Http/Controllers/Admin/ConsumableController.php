<?php

namespace App\Http\Controllers\Admin;

use App\Exports\RequestConsumableExport;
use App\Http\Controllers\Controller;
use App\Imports\ConsumablesImport;
use App\Models\Consumable;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
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
                    return '<a href="' . route('admin.consumable.show', $row) . '" class="btn btn-sm btn-success">Show</a>
                            <a href="' . route('admin.consumable.edit', $row) . '" class="btn btn-sm btn-primary">Edit</a>
                            <form action="' . route('admin.consumable.destroy', $row) . '" method="POST" class="d-inline">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="_token" value="'.csrf_token().'" />
                                <a href="#" class="btn btn-sm btn-danger" onclick="event.preventDefault(); deleteConfirm(this)">Delete</a>
                            </form>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('pages.admin.consumable.index', [
            'title' => 'Consumables',
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
        } catch (Exception $exception) {
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
        } catch (Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }

    public function export(Request $request)
    {
        try {
            $since = $request->get('consumable-request-report-since');
            $until = $request->get('consumable-request-report-until');
            $filename = time() . '_' . $since . '_-_' . $until . '-request-consumable-report.xlsx';

            return Excel::download(new RequestConsumableExport(Carbon::parse($since), Carbon::parse($until)->addDay()), $filename);
        } catch (Exception $exception) {
            dd($exception->getMessage());
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
        } catch (Exception $exception) {
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
        } catch (Exception $exception) {
            return redirect()->route('admin.consumable.index')->with('error', $exception->getMessage());
        }
    }
}
