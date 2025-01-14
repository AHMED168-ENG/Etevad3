<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class RolesSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $SuperAdmin = Role::create(["name" => "Super Admin" , "guard_name" => "Admin"]);
        $Admin = Role::create(["name" => "Admin" , "guard_name" => "Admin"]);
        $permisions = Permission::all();
        $SuperAdmin->syncpermissions($permisions);
        $Admin->syncPermissions([
            'اضافه حدث',
            "تعديل حدث",
            "تفاصيل الحدث",
            "حذف حدث",
            "كل الاحداث",
            "حاله الحدث",
            "ارفاق صوره الحدث",

            'اضافه خبر',
            "تعديل خبر",
            "تفاصيل الخبر",
            "حذف خبر",
            "كل الاخبار",
            "حاله الخبر",
            "ارفاق صوره الخبر",

            'اضافه تغطيه',
            "تعديل تغطيه",
            "تفاصيل التغطيه",
            "حذف تغطيه",
            "كل التغطيات",
            "حاله التغطيه",
            "ارفاق صوره التغطيه",

            'اضافه انجاز',
            "تعديل انجاز",
            "تفاصيل الانجاز",
            "حذف انجاز",
            "كل الانجازات",
            "حاله الانجاز",
            "ارفاق صوره الانجاز",
            "ارفاق الايكون",
            
            'اضافه احصائيه',
            "تعديل احصائيه",
            "تفاصيل الاحصائيه",
            "حذف احصائيه",
            "كل الإحصائيات",
            "حاله الاحصائيه",
            "ارفاق صوره الاحصائيه",
            
            'اضافه بطل',
            "تعديل بطل",
            "تفاصيل البطل",
            "حذف بطل",
            "كل الابطال",
            "حاله البطل",
            "ارفاق صوره البطل",
            
            'اضافه داعم',
            "تعديل داعم",
            "تفاصيل الداعم",
            "حذف داعم",
            "كل الداعمين",
            "حاله الداعم",
            "ارفاق صوره الداعم",
            
            "كل الرسائل",
            "تعديل الرساله",
            "حذف الرساله",
            "تغير رؤيه الرساله",
                       
            "اعدادات الموقع",
            "تعديل اعدادات الموقع",
            "تغير حاله الموقع",
            "ارفاق اللوجو العلوي للاعدادات",
            "ارفاق اللوجو السفلي للاعدادات",
                        
            'اضافه تقرير',
            "تعديل تقرير",
            "تفاصيل التقرير",
            "حذف تقرير",
            "كل التقارير",
            "حاله التقرير",
            "ارفاق صوره التقرير",
                        
            'اضافه مدير',
            "تعديل مدير",
            "تفاصيل المدير",
            "حذف مدير",
            "كل المديرين",
            "حاله المدير",
            "ارفاق صوره المدير",
                        
            "صفحه عنا",
            "تعديل صفحه عنا",
                              
            "كل التسجيلات الخاصه بالاحداث",
            "رؤيه التسجيل",
            "حذف التسجيل",
            "تغير حاله رؤيه التسجيل",
                              
            'اضافه صلاحيه',
            "تعديل صلاحيه",
            "تفاصيل الصلاحيه",
            "حذف صلاحيه",
            "كل الصلحيات",
         
                              
            'اضافه اذون',
            "تعديل اذون",
            "حذف اذون",
            "كل الاوذونات",
        ]);
    }
}
