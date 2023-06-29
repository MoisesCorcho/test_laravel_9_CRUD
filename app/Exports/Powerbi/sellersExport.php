<?php

namespace App\Exports\Powerbi;

use App\Models\User;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithTitle;

class sellersExport implements FromQuery, WithTitle, WithHeadings, WithMapping
{
    public function query()
    {
        $sellersId = User::role("Seller")->pluck('id');

        return User::query()
            ->whereIn('id', $sellersId);
    }

    public function title(): string
    {
        return 'sellers';
    }

    public function headings(): array
    {
        return [
            'id',
            'firstName',
            'lastName',
            'photo',
            'cellphone',
            'email',
            'dniType',
            'dni',
            'active',
            'visitsPerDay'
        ];
    }

    public function map($seller): array
    {
        return [
            $seller->id,
            $seller->firstName,
            $seller->lastName,
            $seller->photo,
            $seller->cellphone,
            $seller->email,
            $seller->dniType,
            $seller->dni,
            $seller->active,
            $seller->visitsPerDay,
        ];
    }
}
