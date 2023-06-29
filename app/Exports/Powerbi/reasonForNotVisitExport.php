<?php

namespace App\Exports\Powerbi;

use App\Models\ReasonForNotVisit;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class reasonForNotVisitExport implements FromQuery, WithTitle, WithHeadings, WithMapping
{

    public function query()
    {
        return ReasonForNotVisit::query();
    }

    public function title(): string
    {
        return 'reasonsForNotVisit';
    }

    public function headings(): array
    {
        return [
            'id',
            'name',
            'active'
        ];
    }

    public function map($reason): array
    {
        return [
            $reason->id,
            $reason->name,
            $reason->active
        ];
    }
}

