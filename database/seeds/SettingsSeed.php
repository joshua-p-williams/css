<?php

use Illuminate\Database\Seeder;

class SettingsSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            
            ['id' => 1, 'top_scores_keep' => '99999', ],

        ];

        foreach ($items as $item) {
            \App\Settings::create($item);
        }
    }
}
