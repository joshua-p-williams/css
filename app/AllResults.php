<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TeamRanking
 *
 * @package App
 * @property string $event
 * @property string $participant
 * @property integer $TeamRanking
*/
class AllResults extends Model
{
    protected $table = 'v_all_results';
    protected $primaryKey = 'participant_id';
}
