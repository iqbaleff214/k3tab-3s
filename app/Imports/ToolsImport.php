<?php

namespace App\Imports;

use App\Models\Tool;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ToolsImport implements ToCollection, WithHeadingRow, WithBatchInserts
{
    /**
     * @param Collection $collections
     * @return void
     */
    public function collection(Collection $collections)
    {
        foreach ($collections as $collection) {
            $data = [];
            try {
                $data = [
                    'part_number' => $collection['part_number'],
                    'tech_ident_number' => $collection["tech_ident_number"],
                    'business_area' => $collection["business_area"],
                    'maintenance_plant' => $collection["maintenance_plant"],
                    'material' => $collection["material"],
                    'manufacturer' => $collection["manufacturer"],
                    'description' => $collection["description"],
                    'additional_description' => $collection['additional_description'],
                    'size' => $collection['size'],
                    'manufacture_serial_number' => $collection['manufacture_serial_number'],
                    'asset' => $collection['asset'],
                    'location' => $collection['location'],
                    'license_number' => $collection['license_number'],
                    'system_status' => $collection['system_status'],
                    'user_status' => $collection['user_status'],
                    'sort_field' => $collection['sort_field'],
                    'equipment_category' => $collection['equipment_category'],
                    'currency' => $collection['currency'],
                    'acquisition_value' => $collection['acquisition_value'],
                    'startup_date' => Date::excelToDateTimeObject($collection['start_up_date']),
                    'changed_by' => $collection['changed_by'],
                    'created_by' => $collection['created_by'],
                    'abc_indicator' => $collection['abc_indic'],
                    'acquisition_date' => Date::excelToDateTimeObject($collection['acquisition_date']),
                    'created_at' => Date::excelToDateTimeObject($collection['created_on']),
                ];
                Tool::create($data);
            } catch (\Exception $exception) {
                echo $exception->getMessage();
            }
        }
    }

    public function batchSize(): int
    {
        return 250;
    }
}
