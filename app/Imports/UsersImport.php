<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToCollection, WithHeadingRow, WithBatchInserts
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        foreach ($collection as $item) {
            $data = [
                'salary_number' => $item['salary_number'],
                'name' => $item['name'],
                'email' => $item['email'],
                'address' => $item['address'],
                'phone_number' => $item['phone_number'],
                'password' => Hash::make($item['salary_number'])
            ];

            if ($user = User::where('salary_number', $item['salary_number'])->first()) {
                $user->update($data);
            } else {
                User::create($data);
            }
        }
    }

    public function batchSize(): int
    {
        return 250;
    }
}
