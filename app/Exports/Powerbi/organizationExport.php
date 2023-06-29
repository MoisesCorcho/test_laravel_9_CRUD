<?php

namespace App\Exports\Powerbi;

use App\Models\Organization;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class organizationExport implements FromQuery, WithTitle, WithHeadings, WithMapping
{

    public function query()
    {
        return Organization::query();
    }

    public function title(): string
    {
        return 'organizations';
    }

    public function headings(): array
    {
        return [
            'id',
            'name',
            'description',
            'nit',
            'address',
            'cellphone',
            'phone',
            'email',
            'city',
            'sellerId'
        ];
    }

    public function map($organization): array
    {
        return [
            $organization->id,
            $organization->name,
            $organization->description,
            $organization->nit,
            $organization->address,
            $organization->cellphone,
            $organization->phone,
            $organization->email,
            $organization->city,
            $organization->sellerId
        ];
    }
}
