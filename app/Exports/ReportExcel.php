<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

use App\Models\Report;
class ReportExcel implements FromCollection , WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {

        return Report::all();
    }
     public function headings(): array
    {
        $report = Report::all();
        $report = $report->first();
        $attributes = array_keys($report->toArray());
        return $attributes;
    }
}
