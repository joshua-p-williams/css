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
class Score extends Model
{
    use SoftDeletes;

    
    protected $fillable = ['score', 'event_id', 'team_id', 'participant_id'];
    

    public static function storeValidation($request)
    {
        return [
            'event_id' => 'integer|exists:events,id|max:4294967295|required|uniqueScore',
            'team_id' => 'integer|exists:participant_teams,id|max:4294967295|required|participantMatchesTeam',
            'participant_id' => 'integer|exists:participants,id|max:4294967295|required',
            'score' => 'integer|max:2147483647|required'
        ];
    }

    public static function updateValidation($request)
    {
        return [
            'event_id' => 'integer|exists:events,id|max:4294967295|required|uniqueScore',
            'team_id' => 'integer|exists:participant_teams,id|max:4294967295|required|participantMatchesTeam',
            'participant_id' => 'integer|exists:participants,id|max:4294967295|required',
            'score' => 'integer|max:2147483647|required'
        ];
    }

    

    
    
    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id')->withTrashed();
    }
    
    public function team()
    {
        return $this->belongsTo(ParticipantTeam::class, 'team_id');
    }
    
    public function participant()
    {
        return $this->belongsTo(Participant::class, 'participant_id');
    }
    
    
}
