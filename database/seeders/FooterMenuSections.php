<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FooterMenuSection;
class FooterMenuSections extends Seeder
{
    public array $footerMenuSections = [
        [
            'name'       => "About",
        ],
        [
            'name'       => "Services",
        ]
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */



    public function run(){
        if (env('DEMO_MODE')) {
            foreach ($this->footerMenuSections as $footerMenuSection) {
                FooterMenuSection::create([
                    'name'       => $footerMenuSection['name'],
                ]);
            }
        }
    }
}
