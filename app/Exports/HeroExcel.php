<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

use App\Models\Hero;
class HeroExcel implements FromCollection , WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {

        return Hero::all();
    }
     public function headings(): array
    {
        $hero = Hero::all();
        $hero = $hero->first();
        $attributes = array_keys($hero->toArray());
        return $attributes;
    }
}
