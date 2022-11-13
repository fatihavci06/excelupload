<?php

namespace App\Imports;

use App\Models\Student;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Validator;

class studentsImport implements ToCollection, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
         Validator::make($rows->toArray(), [
             '*.ogrenci_no' => 'required|numeric',
             '*.ogrenci_adi' => 'required',
             '*.ogrenci_soyadi' => 'required',
         ])->validate();

        foreach ($rows as $row) {
            Student::updateOrCreate(
                ['ogrenci_no'=>$row['ogrenci_no']],
                [
                    'ogrenci_no' => $row['ogrenci_no'],
                    'ogrenci_adi' => $row['ogrenci_adi'],
                    'ogrenci_soyadi' => $row['ogrenci_soyadi'],
                ]
            );
        }
    }

}
