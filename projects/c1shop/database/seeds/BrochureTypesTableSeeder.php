<?php

use Illuminate\Database\Seeder;

class BrochureTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            0 => 'Рекламный проспект',
            1 => 'Прайс-лист',
        ];
        foreach ($types as $type) {
            DB::table('brochure_types')->insert(
                [
                    'name' =>$type,
                ]
            );
        }
    }
}
