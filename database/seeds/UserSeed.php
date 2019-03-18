<?php

use Illuminate\Database\Seeder;

class UserSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            
            ['id' => 1, 'name' => 'Admin', 'email' => 'admin@admin.com', 'password' => '$2y$10$l/T3B0bcII5SiAFH7LjqkOR/MqgD6z9bZGNhT4GeHeaHVVeF7z9oS', 'remember_token' => '',],

        ];

        foreach ($items as $item) {
            \App\User::create($item);
        }
    }
}
