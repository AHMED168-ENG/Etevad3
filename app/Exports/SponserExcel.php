<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

use App\Models\Sponser;
class SponserExcel implements FromCollection , WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {

        return Sponser::all();
    }
     public function headings(): array
    {
        $sponsers = Sponser::all();
        $sponser = $sponsers->first();
        $attributes = array_keys($sponser->toArray());
        return $attributes;
    }
}
