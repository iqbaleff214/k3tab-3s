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
            $data = [
                'equipment_number' => $collection['equipment'],
                'tech_ident_number' => $collection["techidentno"],
                'business_area' => $collection["business_area"],
                'maintenance_plant' => $collection["maintplant"],
                'material' => $collection["material"],
                'manufacturer' => $collection["manufacturer"],
                'description' => $collection["title_description"],
                'additional_description' => $collection['description'],
                'size' => $collection['sizedimens'],
                'manufacture_serial_number' => $collection['manufserialno'],
                'asset' => $collection['asset'],
                'location' => $collection['location'],
                'license_number' => $collection['license_no'],
                'system_status' => $collection['system_status'],
                'user_status' => $collection['user_status'],
                'sort_field' => $collection['sort_field'],
                'equipment_category' => $collection['equipcategory'],
                'currency' => $collection['currency'],
                'acquisition_value' => $collection['acquistnvalue'],
                'startup_date' => Date::excelToDateTimeObject($collection['start_up_date']),
                'changed_by' => $collection['changed_by'],
                'created_by' => $collection['created_by'],
                'abc_indicator' => $collection['abc_indic'],
                'acquisition_date' => Date::excelToDateTimeObject($collection['acquistion_date']),
                'created_at' => Date::excelToDateTimeObject($collection['created_on']),
            ];
            if ($tool = Tool::where('equipment_number', $collection['equipment'])->first()) {
                $tool->update($data);
            } else {
                Tool::create($data);
            }
        }
    }

    public function batchSize(): int
    {
        return 250;
    }
}
