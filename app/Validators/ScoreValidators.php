<?php

namespace App\Validators;

use Illuminate\Support\Facades\Validator;
use App\Score;
use App\Contact;
use DB;

class ScoreValidators {

    public static function uniqueScore() {
        Validator::extendImplicit('uniqueScore', function ($attribute, $value, $parameters, $validator) {
            $unique = false;
            $data = $validator->getData();

            if (array_key_exists('contact_id', $data) && array_key_exists('event_id', $data)) {
                $constraints = [
                    ['event_id', '=', $data['event_id']],
                    ['contact_id', '=', $data['contact_id']],
                ];
                if (array_key_exists('id', $data)) {
                    $constraints[] = ['id', '<>', $data['id']];
                }
                $duplicate = Score::where($constraints)->first();

                $unique = ($duplicate === null);
            }

            return $unique;
        }, 'The participant has a score for this event.');
    }

    public static function participantMatchesTeam() {
        Validator::extendImplicit('participantMatchesTeam', function ($attribute, $value, $parameters, $validator) {
            $matches = false;
            $data = $validator->getData();

            if (array_key_exists('contact_id', $data) && array_key_exists('company_id', $data)) {
                $contact = Contact::find($data['contact_id']);
                if ($contact !== null) {
                    $matches = ($contact->company_id == $data['company_id']);
                }
            }

            return $matches;
        }, 'The participant is not associated with this team.');
    }

    public static function init() {
        self::uniqueScore();
        self::participantMatchesTeam();
    }
}