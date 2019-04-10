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

    protected $casts = [
        'percent_complete' => 'integer',
    ];    

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

    public function scopeUnfinished($query) {
        return $query->where('percent_complete', '<', 100);
    }

    public function scopeByEventId($query, $val) {
        if (empty($val)) {
            return $query;
        }
        return $query->where('event_id', $val);
    }

    public function scopeByCategoryId($query, $val) {
        if (empty($val)) {
            return $query;
        }
        return $query->where('category_id', $val);
    }
}
