<?php

use Illuminate\Database\Seeder;

class FaqQuestionSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            
            ['id' => 1, 'category_id' => 1, 'question_text' => 'How are winners determined when the score is a tie?', 'answer_text' => 'Scoring Ties for all individuals/teams per event, and overall will be broken. The following tie breaking criteria will be used in the National program. In the event of a tie, the individual/team with the highest level of achievement in the Hunter Responsibility Exam will be declared the winner(s). If a tie remains, the individual/team with the highest level of achievement on the Hunter Safety Trail Challenge will be declared the winner(s). Should a tie remain, the individual/team with the highest combined level of achievement in the four (4) responsibility events( Hunter Responsibility Exam, Hunting Orienteering Skills Challenge, Hunting Wildlife Identification Challenge, Hunter Safety Trail Challenge), will be declared the winner(s). The final tie breaker will be based on a combined score of the four (4) shooting events( Hunting Shotgun Challenge, The Light Rifle Challenge, Hunting Archery Challenge, and the Hunting Muzzleloader Challenge). Should individuals/teams tie in the Hunter Responsibility Exam, the tie breaking formula will start at the second criteria( Hunter Safety Trail Challenge).',],

        ];

        foreach ($items as $item) {
            \App\FaqQuestion::create($item);
        }
    }
}
