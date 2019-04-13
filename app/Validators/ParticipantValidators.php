<?php

namespace App\Validators;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\ParticipantTeam;
use App\Participant;
use DB;

class ParticipantValidators {

    public static function categoryMatchesTeam() {
        Validator::extendImplicit('categoryMatchesTeam', function ($attribute, $value, $parameters, $validator) {
            $matches = false;
            $data = $validator->getData();

            if (array_key_exists('team_id', $data)) {
                $team = ParticipantTeam::find($data['team_id']);
                if ($team !== null) {
                    $matches = ($team->category_id == $value);
                }
            }

            return $matches;
        }, 'The participant category does not match the team category.');
    }

    public static function uniqueParticipant() {
        Validator::extendImplicit('uniqueParticipant', function ($attribute, $value, $parameters, $validator) {
            $unique = false;
            $data = $validator->getData();

            if (array_key_exists('team_id', $data)) {
                $constraints = [
                    [\DB::raw('UPPER(name)'), 'LIKE', '%' . strtoupper($value) . '%'],
                    ['team_id', '=', $data['team_id']],
                ];
                if (array_key_exists('id', $data)) {
                    $constraints[] = ['id', '<>', $data['id']];
                }
                $duplicate = Participant::where($constraints)->first();

                $unique = ($duplicate === null);
            }

            return $unique;
        }, 'The participant has already been added');
    }

    public static function init() {
        self::categoryMatchesTeam();
        self::uniqueParticipant();
    }
}