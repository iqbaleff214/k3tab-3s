<?php

namespace App\Exports;

use App\Models\RequestTool;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RequestToolExport implements FromCollection, WithHeadings
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
        $data = RequestTool::selectRaw('
            request_tools.id,
            request_tools.created_at,
            users.name,
            users.salary_number,
            tools.description,
            tools.part_number,
            CASE WHEN request_tools.request_status = 0 THEN "Requested" WHEN request_tools.request_status = 1 THEN "Borrowed" WHEN request_tools.request_status = 2 THEN "Returned" WHEN request_tools.request_status = 3 THEN "Rejected" ELSE "Unknown" END as status
        ')->join('users', 'users.id', '=', 'request_tools.user_id')->join('tools', 'tools.id', '=', 'request_tools.tool_id')->whereBetween('request_tools.created_at', [$this->since, $this->until])->oldest()->get();
        return $data;
    }

    public function headings(): array
    {
        return [
            '#',
            'Request Date',
            'Name',
            'Salary Number',
            'Tool',
            'Tool Number',
            'Status',
        ];
    }
}
