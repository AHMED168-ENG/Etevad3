<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

use App\Models\Event;
class EventExcel implements FromCollection , WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {

        return Event::all();
    }
     public function headings(): array
    {
        $events = Event::all();
        $event = $events->first();
        $attributes = array_keys($event->toArray());
        return $attributes;
    }
}
