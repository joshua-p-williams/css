<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CategoryCompletions
 *
 * @package App
 * @property string $event
 * @property string $contact
 * @property integer $CategoryCompletions
*/
class CategoryCompletion extends Model
{
    protected $table = 'v_category_completion';
    protected $primaryKey = 'none';

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id')->withTrashed();
    }
    
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id')->withTrashed();
    }

    public function scopeHasParticipants($query) {
        return $query->where('participant_count', '>', 0);
    }
}
