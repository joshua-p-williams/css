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
            
            ['id' => 1, 'name' => 'Archery',],
            ['id' => 2, 'name' => 'Shotgun',],
            ['id' => 3, 'name' => 'Rifle',],
            ['id' => 4, 'name' => 'Muzzleloader',],
            ['id' => 5, 'name' => 'Responsibility Exam',],
            ['id' => 6, 'name' => 'Safety Trail',],
            ['id' => 7, 'name' => 'Wildlife Identification',],
            ['id' => 8, 'name' => 'Orienteering',],

        ];

        foreach ($items as $item) {
            \App\Event::create($item);
        }
    }
}
