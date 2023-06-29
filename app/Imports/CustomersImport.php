<?php

namespace App\Imports;

use App\Models\Organization;
use Maatwebsite\Excel\Concerns\ToModel;

use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;

class CustomersImport implements
    ToModel,
    WithHeadingRow,
    SkipsOnError,
    WithValidation,
    SkipsOnFailure
{

    use Importable, SkipsErrors, SkipsFailures;

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Organization([
            'nit' => trim($row['nit']),
            'address' => trim($row['direccion']),
            'name' => trim($row['nombre']),
            'city' => trim($row['ciudad']),
            'cellphone' => trim($row['telefono_1']),
        ]);
    }

    public function rules(): array
    {
        return [
            '*.nit' => 'unique:organizations,nit',
        ];
    }

    public function headingRow(): int
    {
        return 7;
    }
}
