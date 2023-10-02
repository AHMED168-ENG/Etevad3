<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

use App\Models\Permission;
class PermissionExcel implements FromCollection , WithHeadings
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
        $permission = Permission::all();
        $permission = $permission->first();
        $attributes = array_keys($permission->toArray());
        return $attributes;
    }
}
