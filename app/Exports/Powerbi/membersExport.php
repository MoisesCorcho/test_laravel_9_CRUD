<?php

namespace App\Exports\Powerbi;

use App\Models\Member;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class membersExport implements FromQuery, WithTitle, WithHeadings, WithMapping
{

    public function query()
    {
        return Member::query();
    }

    public function title(): string
    {
        return 'members';
    }

    public function headings(): array
    {
        return [
            'id',
            'firstName',
            'lastName',
            'dniType',
            'dni',
            'address',
            'cellphone1',
            'cellphone2',
            'phone',
            'birthday',
            'email',
            'organizationId',
            'memberPositionId'
        ];
    }

    public function map($member): array
    {
        return [
            $member->id,
            $member->firstName,
            $member->lastName,
            $member->dniType,
            $member->dni,
            $member->address,
            $member->cellphone1,
            $member->cellphone2,
            $member->phone,
            $member->birthday,
            $member->email,
            $member->organizationId,
            $member->memberPositionId
        ];
    }
}
