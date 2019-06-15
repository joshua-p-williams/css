<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Score
 *
 * @package App
 * @property string $event
 * @property string $team
 * @property string $participant
 * @property integer $score
*/
class Settings extends Model
{
    
    protected $fillable = ['top_scores_keep', ];
    

    public static function storeValidation($request)
    {
        return [
            'top_scores_keep' => 'integer|required',
        ];
    }

    public static function updateValidation($request)
    {
        return [
            'top_scores_keep' => 'integer|required',
        ];
    }
    
}
