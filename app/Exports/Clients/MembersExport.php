<?php

namespace App\Exports\Clients;

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

class MembersExport implements
    FromCollection,
    WithHeadings,
    WithEvents,
    ShouldAutoSize,
    WithDrawings,
    WithCustomStartCell,
    WithMapping
{

    public $idOrganization;

    public function __construct()
    {
        $this->idOrganization = request()->organizationId;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Member::where('organizationId', $this->idOrganization)->get();
    }

    public function headings(): array
    {
        return [
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
            'organization',
        ];
    }

    public function map($member): array
    {
        return [
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
            $member->organization->name,
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->getStyle('B8:L8')->applyFromArray([
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

                $numero = Member::where('organizationId', $this->idOrganization)->count() + 8;

                $event->sheet->getStyle('B9:L'."{$numero}")->applyFromArray([
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
        $drawing->setCoordinates('G3');

        return $drawing;
    }
}
