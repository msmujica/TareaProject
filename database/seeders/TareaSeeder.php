<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TareaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Tarea::factory(3)->create();
    }
}
