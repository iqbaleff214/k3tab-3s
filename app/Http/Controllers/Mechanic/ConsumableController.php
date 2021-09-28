<?php

namespace App\Http\Controllers\Mechanic;

use App\Http\Controllers\Controller;
use App\Models\Consumable;
use App\Models\RequestConsumable;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ConsumableController extends Controller
{
    public function index(): Renderable
    {
        return view('pages.mechanic.consumable.index', [
            'title' => 'Consumables'
        ]);
    }

    public function show(Consumable $consumable): Renderable
    {
        return view('pages.mechanic.consumable.show', [
            'title' => 'Show Consumable',
            'forms' => [
                'consumable_number' => 'text',
                'description' => 'text',
                'additional_description' => 'text',
                'unit' => 'text',
                'quantity' => 'number',
            ],
            'consumable' => $consumable
        ]);
    }

    public function data(Request $request): JsonResponse
    {
        $data = Consumable::where('consumable_number', '!=', null);
        if ($request->get('q')) {
            $data = $data->where('description', 'like', "%" . $request->get('q') . "%")->orWhere('consumable_number', 'like', "%" . $request->get('q') . "%");
        }
        return response()->json($data->paginate(9));
    }

    public function order(Request $request, Consumable $consumable): RedirectResponse
    {
        if ($consumable->quantity < $request->input('quantity')) {
            return back()->with('info', 'Insufficient quantity!');
        }

        try {
            RequestConsumable::create([
                'user_id' => auth()->user()->id,
                'consumable_id' => $consumable->id,
                'requested_quantity' => $request->input('quantity')
            ]);

            return back()->with('success', 'Successfully requested the consumable!');

        } catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }
}
