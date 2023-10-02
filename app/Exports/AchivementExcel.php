<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

use App\Models\Achivement;
class AchivementExcel implements FromCollection , WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {

        return Achivement::all();
    }
     public function headings(): array
    {
        $achivement = Achivement::all();
        $achivement = $achivement->first();
        $attributes = array_keys($achivement->toArray());
        return $attributes;
    }
}
