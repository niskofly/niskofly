<?php

use Illuminate\Database\Seeder;

class ActionFiltersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'Для прачечных',
            'Для морских судов',
            'Для швейного произв-ва',
            'Для мед.центров',
        ];
        foreach ($data as $insertInfo){
            DB::table('napravlenie')->insert(
                [
                    'name' =>$insertInfo,
                    'url' => str_slug($insertInfo),
                ]
            );
        }
    }
}


