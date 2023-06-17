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
class OverallRanking extends Model
{
    protected $table = 'v_overall_ranking';
    protected $primaryKey = 'participant_id';

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id')->withTrashed();
    }
    
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id')->withTrashed();
    }
    
    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id');
    }
    
    public function participant()
    {
        return $this->belongsTo(Participant::class, 'participant_id');
    }

    public function scopeByTop($query, $id) {
        return $query->orderBy('ranking')->where('ranking', '<=', $id);
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
