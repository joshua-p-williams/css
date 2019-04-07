<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class IndividualRanking
 *
 * @package App
 * @property string $event
 * @property string $contact
 * @property integer $IndividualRanking
*/
class IndividualRanking extends Model
{
    protected $table = 'v_individual_ranking';
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
    
    public function contact()
    {
        return $this->belongsTo(Contact::class, 'contact_id');
    }

    public function scopeUnScored($query) {
        return $query->whereNull('score_id');
    }
}
