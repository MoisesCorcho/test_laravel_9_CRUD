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

class ClientsExport implements
    FromCollection,
    WithHeadings,
    WithEvents,
    ShouldAutoSize,
    WithDrawings,
    WithCustomStartCell,
    WithMapping
{
    public $fechaInicio;
    public $fechaFinal;


    public function __construct()
    {
        $this->fechaInicio = request()->fecha_inicio;
        $this->fechaFinal = request()->fecha_final;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $fInicio = $this->fechaInicio;
        $fFinal  = $this->fechaFinal;

        return Organization::when($fFinal, function ($query) use ($fInicio, $fFinal) {
            $query->whereBetween('organizations.created_at', [$fInicio, $fFinal]);
        })->get();
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

                $fInicio = $this->fechaInicio;
                $fFinal  = $this->fechaFinal;

                $numero = Organization::when($fFinal, function ($query) use ($fInicio, $fFinal) {
                    $query->whereBetween('organizations.created_at', [$fInicio, $fFinal]);
                })->count() + 8;

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
