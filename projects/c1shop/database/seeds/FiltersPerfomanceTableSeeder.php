<?php

use Illuminate\Database\Seeder;

class FiltersPerfomanceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $type = 'performance';
        $data = [
            '20-25',
            '25-30',
            '30-35',
            '35-40',
            '40-50',
            '50-60',
            '60-80',
            '80-105',
            '105-170',
            '170-260',
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
