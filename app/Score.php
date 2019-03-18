<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Score
 *
 * @package App
 * @property string $event
 * @property string $company
 * @property string $contact
 * @property integer $score
*/
class Score extends Model
{
    use SoftDeletes;

    
    protected $fillable = ['score', 'event_id', 'company_id', 'contact_id'];
    

    public static function storeValidation($request)
    {
        return [
            'event_id' => 'integer|exists:events,id|max:4294967295|required',
            'company_id' => 'integer|exists:contact_companies,id|max:4294967295|nullable',
            'contact_id' => 'integer|exists:contacts,id|max:4294967295|required',
            'score' => 'integer|max:2147483647|required'
        ];
    }

    public static function updateValidation($request)
    {
        return [
            'event_id' => 'integer|exists:events,id|max:4294967295|required',
            'company_id' => 'integer|exists:contact_companies,id|max:4294967295|nullable',
            'contact_id' => 'integer|exists:contacts,id|max:4294967295|required',
            'score' => 'integer|max:2147483647|required'
        ];
    }

    

    
    
    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id')->withTrashed();
    }
    
    public function company()
    {
        return $this->belongsTo(ContactCompany::class, 'company_id');
    }
    
    public function contact()
    {
        return $this->belongsTo(Contact::class, 'contact_id');
    }
    
    
}
