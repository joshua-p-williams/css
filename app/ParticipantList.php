<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ParticipantList
 *
 * @package App
 * @property string $event
 * @property string $participant
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
