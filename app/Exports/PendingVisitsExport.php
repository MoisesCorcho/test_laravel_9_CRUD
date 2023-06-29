<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithMapping;

class PendingVisitsExport implements
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
        return $users = User::query()
            ->join('visits', 'users.id', '=', 'visits.sellerId')
            ->join('reasonForNotVisits', 'reasonForNotVisits.id', '=', 'visits.reasonForNotVisitId')
            ->select('users.*', 'visits.*', 'reasonForNotVisits.*')
            ->where('status', 'notVisited')
            ->get();
    }

    public function headings(): array
    {
        return [
            'nombre',
            'dni',
            'celular',
            'correo electronico',
            'estado de la visita',
            'descripcion estado visita',
            'fecha visita',
            'fecha de reagendamiento',
            'razon de cancelacion'
        ];
    }

    public function map($user): array
    {
        return [
            $user->firstName . ' ' . $user->lastName,
            $user->dni,
            $user->cellphone,
            $user->email,
            $user->status,
            $user->reasonForNotVisitDesc,
            $user->visitDate,
            $user->rescheduledDate,
            $user->name,
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->getStyle('B8:J8')->applyFromArray([
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

                $numero = User::query()
                    ->join('visits', 'users.id', '=', 'visits.sellerId')
                    ->join('reasonForNotVisits', 'reasonForNotVisits.id', '=', 'visits.reasonForNotVisitId')
                    ->select('users.*', 'visits.*', 'reasonForNotVisits.*')
                    ->where('status', 'notVisited')
                    ->count() + 8;

                $event->sheet->getStyle('B9:J'."{$numero}")->applyFromArray([
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
        $drawing->setCoordinates('F3');

        return $drawing;
    }
}
