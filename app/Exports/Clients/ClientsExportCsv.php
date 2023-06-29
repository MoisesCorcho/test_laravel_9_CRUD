<?php

namespace App\Exports\Clients;

use App\Models\Organization;
use Maatwebsite\Excel\Concerns\FromCollection;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithMapping;

class ClientsExportCsv implements
    FromCollection,
    WithHeadings,
    ShouldAutoSize,
    WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Organization::all();
    }

    public function headings(): array
    {
        return [
            'name',
            'description',
            'nit',
            'address',
            'cellphone',
            'phone',
            'email',
            'city',
        ];
    }

    public function map($client): array
    {
        return [
            $client->name,
            $client->description,
            $client->nit,
            $client->address,
            $client->cellphone,
            $client->phone,
            $client->email,
            $client->city,
        ];
    }


}
