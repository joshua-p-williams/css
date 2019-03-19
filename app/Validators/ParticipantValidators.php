<?php

namespace App\Validators;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\ContactCompany;
use App\Contact;
use DB;

class ParticipantValidators {

    public static function categoryMatchesTeam() {
        Validator::extendImplicit('categoryMatchesTeam', function ($attribute, $value, $parameters, $validator) {
            $matches = false;
            $data = $validator->getData();

            if (array_key_exists('company_id', $data)) {
                $company = ContactCompany::find($data['company_id']);
                if ($company !== null) {
                    $matches = ($company->category_id == $value);
                }
            }

            return $matches;
        }, 'The participant category does not match the team category.');
    }

    public static function uniqueParticipant() {
        Validator::extendImplicit('uniqueParticipant', function ($attribute, $value, $parameters, $validator) {
            $unique = false;
            $data = $validator->getData();

            if (array_key_exists('company_id', $data)) {
                $constraints = [
                    [\DB::raw('UPPER(name)'), 'LIKE', '%' . strtoupper($value) . '%'],
                    ['company_id', '=', $data['company_id']],
                ];
                if (array_key_exists('id', $data)) {
                    $constraints[] = ['id', '<>', $data['id']];
                }
                $duplicate = Contact::where($constraints)->first();

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