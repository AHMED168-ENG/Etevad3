<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

use App\Models\Contact_us;
class MessageExcel implements FromCollection , WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {

        return Contact_us::all();
    }
     public function headings(): array
    {
        $contact_us = Contact_us::all();
        $contact_us = $contact_us->first();
        $attributes = array_keys($contact_us->toArray());
        return $attributes;
    }
}
