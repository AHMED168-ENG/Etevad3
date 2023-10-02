<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

use App\Models\Contact_us;
class RecordingExcel implements FromCollection , WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {

        return Event_recordings::all();
    }
     public function headings(): array
    {
        $recording = Event_recordings::all();
        $recording = $recording->first();
        $attributes = array_keys($recording->toArray());
        return $attributes;
    }
}
