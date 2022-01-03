<?php

use Illuminate\Database\Seeder;

class WidthFiltersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $type = 'width_area';
        $data = [
            '120-140',
            '140-160',
            '160-180',
            '180-200',
            '200-220',
            '220-280'
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








