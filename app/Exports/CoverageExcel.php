<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

use App\Models\Coverage;
class CoverageExcel implements FromCollection , WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {

        return Coverage::all();
    }
     public function headings(): array
    {
        $coverage = Coverage::all();
        $coverage = $coverage->first();
        $attributes = array_keys($coverage->toArray());
        return $attributes;
    }
}
