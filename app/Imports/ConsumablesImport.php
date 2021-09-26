<?php

namespace App\Imports;

use App\Models\Consumable;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ConsumablesImport implements ToCollection, WithBatchInserts, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        foreach ($collection as $item) {
            $data = [
                'consumable_number' => $item['consumable_number'],
                'description' => $item['consumable_description'],
                'additional_description' => $item['description'],
                'quantity' => $item['quantity'],
                'unit' => $item['unit'],
            ];

            if ($consumable = Consumable::where('consumable_number', $item['consumable_number'])->first()) {
                $consumable->update($data);
            } else {
                Consumable::create($data);
            }
        }
    }

    public function batchSize(): int
    {
        return 250;
    }
}
