<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

use App\Models\Role;
class RoleExcel implements FromCollection , WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {

        return Role::all();
    }
     public function headings(): array
    {
        $roles = Role::all();
        $role = $roles->first();
        $attributes = array_keys($role->toArray());
        return $attributes;
    }
}
