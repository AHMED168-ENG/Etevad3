<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

use App\Models\User;
class UserExcel implements FromCollection , WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {

        return User::all();
    }
     public function headings(): array
    {
        $users = User::all();
        $user = $users->first();
        $attributes = array_keys($user->toArray());
        return $attributes;
    }
}
