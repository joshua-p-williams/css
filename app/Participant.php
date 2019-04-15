<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Participant
 *
 * @package App
 * @property string $team
 * @property string $category
 * @property string $name
 * @property string $phone
 * @property string $email
 * @property string $address
*/
class Participant extends Model
{
    
    protected $fillable = ['name', 'phone', 'email', 'address', 'team_id', 'category_id'];
    

    public static function storeValidation($request)
    {
        return [
            'team_id' => 'integer|exists:teams,id|max:4294967295|required',
            'category_id' => 'integer|exists:categories,id|max:4294967295|required|categoryMatchesTeam',
            'name' => 'max:191|required|uniqueParticipant',
            'phone' => 'max:191|nullable',
            'email' => 'max:191|nullable',
            'address' => 'max:191|nullable'
        ];
    }

    public static function updateValidation($request)
    {
        return [
            'team_id' => 'integer|exists:teams,id|max:4294967295|required',
            'category_id' => 'integer|exists:categories,id|max:4294967295|required|categoryMatchesTeam',
            'name' => 'max:191|required|uniqueParticipant',
            'phone' => 'max:191|nullable',
            'email' => 'max:191|nullable',
            'address' => 'max:191|nullable'
        ];
    }

    

    
    
    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id');
    }
    
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id')->withTrashed();
    }
    
    
}
