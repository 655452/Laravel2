<?php

namespace Database\Seeders;

use App\Models\Template;
use Illuminate\Database\Seeder;

class TemplateTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Template::insert([
            [
                'name' => 'default',
            ],
            [
                'name' => 'about',
            ],
            [
                'name' => 'contact',
            ],
        ]);
    }
}
