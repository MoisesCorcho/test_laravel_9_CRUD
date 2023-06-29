<?php

namespace App\Exports\MemberOrganizations;

use App\Models\Member;
use Maatwebsite\Excel\Concerns\FromCollection;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithMapping;

class MembersOrganizationExport implements
    FromCollection,
    WithHeadings,
    WithEvents,
    ShouldAutoSize,
    WithDrawings,
    WithCustomStartCell,
    WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Member::all();
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

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->getStyle('B8:I8')->applyFromArray([
                    'font' => [
                        'bold' => true
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ],
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'color' => [
                            'argb' => '85C1E9',
                        ],
                    ],
                ]);

                $email = request()->email;
                // $numero = User::select('name', 'email', 'created_at')->where('email', 'LIKE', "%{$email}%")->count() + 8;
                $numero = Member::all()->count() + 8;

                $event->sheet->getStyle('B9:I'."{$numero}")->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ],
                    ],
                ]);
            },
        ];
    }

    public function startCell(): string
    {
        return 'B8';
    }

    public function drawings()
    {
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('This is my logo');
        $drawing->setPath(public_path('/laravel-logo.png'));
        $drawing->setHeight(90);
        $drawing->setCoordinates('E3');

        return $drawing;
    }
}
