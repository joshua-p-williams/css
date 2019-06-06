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
class ParticipantList extends Model
{
    protected $table = 'v_participant_list';
    protected $primaryKey = 'participant_id';

    public function participant()
    {
        return $this->belongsTo(Participant::class, 'participant_id');
    }
}
