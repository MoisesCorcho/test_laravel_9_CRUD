<?php

namespace App\Exports\Powerbi;

use App\Models\MemberPosition;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class membersPositionExport implements FromQuery, WithTitle, WithHeadings, WithMapping
{

    public function query()
    {
        return MemberPosition::query();
    }

    public function title(): string
    {
        return 'membersPosition';
    }

    public function headings(): array
    {
        return [
            'id',
            'name',
            'description'
        ];
    }

    public function map($memberPosition): array
    {
        return [
            $memberPosition->id,
            $memberPosition->name,
            $memberPosition->description
        ];
    }
}
