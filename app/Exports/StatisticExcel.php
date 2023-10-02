<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

use App\Models\Statistic;
class StatisticExcel implements FromCollection , WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {

        return Statistic::all();
    }
     public function headings(): array
    {
        $statistic = Statistic::all();
        $statistic = $statistic->first();
        $attributes = array_keys($statistic->toArray());
        return $attributes;
    }
}
