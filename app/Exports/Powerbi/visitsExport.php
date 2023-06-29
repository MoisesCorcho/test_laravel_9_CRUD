<?php

namespace App\Exports\Powerbi;

use App\Models\Visit;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithTitle;

class visitsExport implements FromQuery, WithTitle, WithHeadings, WithMapping
{
    public function query()
    {
        return Visit::query();
    }

    public function title(): string
    {
        return 'visits';
    }

    public function headings(): array
    {
        return [
            'id',
            'visitDate',
            'rescheduledDate',
            'reasonForNotVisitDesc',
            'status',
            'sellerId',
            'reasonForNotVisitId',
            'organizationId',
            'surveyId'
        ];
    }

    public function map($visit): array
    {
        return [
            $visit->id,
            $visit->visitDate,
            $visit->rescheduledDate,
            $visit->reasonForNotVisitDesc,
            $visit->status,
            $visit->sellerId,
            $visit->reasonForNotVisitId,
            $visit->organizationId,
            $visit->surveyId
        ];
    }
}
