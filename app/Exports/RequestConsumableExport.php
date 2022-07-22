<?php

namespace App\Exports;

use App\Models\RequestConsumable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RequestConsumableExport implements FromCollection, WithHeadings
{
    private $since;
    private $until;

    public function __construct($since, $until) {
        $this->since = $since;
        $this->until = $until;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $data = RequestConsumable::selectRaw('
            request_consumables.id,
            request_consumables.created_at,
            users.name,
            users.salary_number,
            consumables.description,
            consumables.consumable_number,
            consumables.quantity,
            request_consumables.requested_quantity,
            request_consumables.accepted_quantity,
            CASE WHEN request_consumables.request_status = 0 THEN "Requested" WHEN request_consumables.request_status = 1 THEN "Accepted" WHEN request_consumables.request_status = 2 THEN "Returned" WHEN request_consumables.request_status = 3 THEN "Rejected" ELSE "Unknown" END as status
        ')->join('users', 'users.id', '=', 'request_consumables.user_id')->join('consumables', 'consumables.id', '=', 'request_consumables.consumable_id')->whereBetween('request_consumables.created_at', [$this->since, $this->until])->oldest()->get();
        return $data;
    }

    public function headings(): array
    {
        return [
            '#',
            'Request Date',
            'Name',
            'Salary Number',
            'Consumable',
            'Consumable Number',
            'Stock',
            'Req Qty',
            'Acc Qty',
            'Status',
        ];
    }
}
