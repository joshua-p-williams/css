<?php

use Illuminate\Database\Seeder;

class PermissionSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            
            ['id' => 1, 'title' => 'user_management_access',],
            ['id' => 2, 'title' => 'permission_access',],
            ['id' => 3, 'title' => 'permission_create',],
            ['id' => 4, 'title' => 'permission_edit',],
            ['id' => 5, 'title' => 'permission_view',],
            ['id' => 6, 'title' => 'permission_delete',],
            ['id' => 7, 'title' => 'role_access',],
            ['id' => 8, 'title' => 'role_create',],
            ['id' => 9, 'title' => 'role_edit',],
            ['id' => 10, 'title' => 'role_view',],
            ['id' => 11, 'title' => 'role_delete',],
            ['id' => 12, 'title' => 'user_access',],
            ['id' => 13, 'title' => 'user_create',],
            ['id' => 14, 'title' => 'user_edit',],
            ['id' => 15, 'title' => 'user_view',],
            ['id' => 16, 'title' => 'user_delete',],
            ['id' => 18, 'title' => 'faq_management_create',],
            ['id' => 19, 'title' => 'faq_management_edit',],
            ['id' => 20, 'title' => 'faq_management_view',],
            ['id' => 21, 'title' => 'faq_management_delete',],
            ['id' => 34, 'title' => 'category_access',],
            ['id' => 35, 'title' => 'category_create',],
            ['id' => 36, 'title' => 'category_edit',],
            ['id' => 37, 'title' => 'category_view',],
            ['id' => 38, 'title' => 'category_delete',],
            ['id' => 49, 'title' => 'event_access',],
            ['id' => 50, 'title' => 'event_create',],
            ['id' => 51, 'title' => 'event_edit',],
            ['id' => 52, 'title' => 'event_view',],
            ['id' => 53, 'title' => 'event_delete',],
            ['id' => 54, 'title' => 'score_access',],
            ['id' => 55, 'title' => 'score_create',],
            ['id' => 56, 'title' => 'score_edit',],
            ['id' => 57, 'title' => 'score_view',],
            ['id' => 58, 'title' => 'score_delete',],
            ['id' => 59, 'title' => 'faq_management_access',],
            ['id' => 60, 'title' => 'faq_category_access',],
            ['id' => 61, 'title' => 'faq_category_create',],
            ['id' => 62, 'title' => 'faq_category_edit',],
            ['id' => 63, 'title' => 'faq_category_view',],
            ['id' => 64, 'title' => 'faq_category_delete',],
            ['id' => 65, 'title' => 'faq_question_access',],
            ['id' => 66, 'title' => 'faq_question_create',],
            ['id' => 67, 'title' => 'faq_question_edit',],
            ['id' => 68, 'title' => 'faq_question_view',],
            ['id' => 69, 'title' => 'faq_question_delete',],
            ['id' => 70, 'title' => 'participant_management_access',],
            ['id' => 71, 'title' => 'participant_management_create',],
            ['id' => 72, 'title' => 'participant_management_edit',],
            ['id' => 73, 'title' => 'participant_management_view',],
            ['id' => 74, 'title' => 'participant_management_delete',],
            ['id' => 75, 'title' => 'participant_team_access',],
            ['id' => 76, 'title' => 'participant_team_create',],
            ['id' => 77, 'title' => 'participant_team_edit',],
            ['id' => 78, 'title' => 'participant_team_view',],
            ['id' => 79, 'title' => 'participant_team_delete',],
            ['id' => 80, 'title' => 'participant_access',],
            ['id' => 81, 'title' => 'participant_create',],
            ['id' => 82, 'title' => 'participant_edit',],
            ['id' => 83, 'title' => 'participant_view',],
            ['id' => 84, 'title' => 'participant_delete',],
            ['id' => 85, 'title' => 'team_management_access',],
            ['id' => 86, 'title' => 'competition_access',],

        ];

        foreach ($items as $item) {
            \App\Permission::create($item);
        }
    }
}
