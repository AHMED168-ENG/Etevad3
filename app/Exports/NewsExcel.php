<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

use App\Models\News;
class NewsExcel implements FromCollection , WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {

        return news::all();
    }
     public function headings(): array
    {
        $news = News::all();
        $news = $news->first();
        $attributes = array_keys($news->toArray());
        return $attributes;
    }
}
