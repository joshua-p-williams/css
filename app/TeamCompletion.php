<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TeamCompletions
 *
 * @package App
 * @property string $event
 * @property string $contact
 * @property integer $TeamCompletions
*/
class TeamCompletion extends Model
{
    protected $table = 'v_team_completion';
    protected $primaryKey = 'none';

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id')->withTrashed();
    }
    
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id')->withTrashed();
    }
    
    public function company()
    {
        return $this->belongsTo(ContactCompany::class, 'company_id');
    }

    public function scopeHasParticipants($query) {
        return $query->where('participant_count', '>', 0);
    }
}
