<?php

use Illuminate\Database\Seeder;

class EventSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            
            ['id' => 1, 'name' => 'Archery', 'use_in_tb_1' => false, 'use_in_tb_2' => false, 'use_in_tb_3' => false, 'use_in_tb_4' => true, ],
            ['id' => 2, 'name' => 'Shotgun', 'use_in_tb_1' => false, 'use_in_tb_2' => false, 'use_in_tb_3' => false, 'use_in_tb_4' => true, ],
            ['id' => 3, 'name' => 'Rifle', 'use_in_tb_1' => false, 'use_in_tb_2' => false, 'use_in_tb_3' => false, 'use_in_tb_4' => true, ],
            ['id' => 4, 'name' => 'Muzzleloader', 'use_in_tb_1' => false, 'use_in_tb_2' => false, 'use_in_tb_3' => false, 'use_in_tb_4' => true, ],
            ['id' => 5, 'name' => 'Responsibility Exam', 'use_in_tb_1' => true, 'use_in_tb_2' => false, 'use_in_tb_3' => true, 'use_in_tb_4' => false, ],
            ['id' => 6, 'name' => 'Safety Trail', 'use_in_tb_1' => false, 'use_in_tb_2' => true, 'use_in_tb_3' => true, 'use_in_tb_4' => false, ],
            ['id' => 7, 'name' => 'Wildlife Identification', 'use_in_tb_1' => false, 'use_in_tb_2' => false, 'use_in_tb_3' => true, 'use_in_tb_4' => false, ],
            ['id' => 8, 'name' => 'Orienteering', 'use_in_tb_1' => false, 'use_in_tb_2' => false, 'use_in_tb_3' => true, 'use_in_tb_4' => false, ],

        ];

        foreach ($items as $item) {
            \App\Event::create($item);
        }
    }
}
