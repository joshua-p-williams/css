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
class OverallTeamRanking extends Model
{
    protected $table = 'v_overall_team_ranking';
    protected $primaryKey = 'team_id';

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

    public function scopeOrderByWinner($query) {
        return $query->orderBy('score', 'desc')
                     ->orderBy('tie_breaker_1', 'desc')
                     ->orderBy('tie_breaker_2', 'desc')
                     ->orderBy('tie_breaker_3', 'desc')
                     ->orderBy('tie_breaker_4', 'desc');
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
