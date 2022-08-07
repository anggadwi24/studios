<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModulSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('moduls')->insert([
            'modul_name' => 'Dashboard',
            'modul_order' => '1',
            'modul_icon' => 'fa fa-tachometer-alt',
            'modul_slug' => 'dashboard',
        ]);
    }
}
