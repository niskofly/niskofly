<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class FiltersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        $type = 'loading';
        $data = [
            '20-30',
            '30-40',
            '40-50',
            '50-60',
            '60-70',
            'от 70',
        ];
        foreach ($data as $insertInfo){
            DB::table('filters')->insert(
                [
                    'name' =>$insertInfo,
                    'active' => 1,
                    'type_filter' => $type,
                    'value' => $insertInfo,
                ]
            );
        }

    }
}
