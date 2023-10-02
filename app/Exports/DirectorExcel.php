<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

use App\Models\Director;
class DirectorExcel implements FromCollection , WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {

        return Director::all();
    }
     public function headings(): array
    {
        $director = Director::all();
        $director = $director->first();
        $attributes = array_keys($director->toArray());
        return $attributes;
    }
}
