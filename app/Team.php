<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Team
 *
 * @package App
 * @property string $name
 * @property string $category
 * @property string $primary_contact_name
 * @property string $primary_contact_phone
 * @property string $primary_contact_email
 * @property string $state
 * @property string $county
*/
class Team extends Model
{
    
    protected $fillable = ['name', 'primary_contact_name', 'primary_contact_phone', 'primary_contact_email', 'state', 'county', 'category_id'];
    

    public static function storeValidation($request)
    {
        return [
            'name' => 'max:191|required|unique:teams,name',
            'category_id' => 'integer|exists:categories,id|max:4294967295|required',
            'primary_contact_name' => 'max:191|required',
            'primary_contact_phone' => 'max:191|nullable',
            'primary_contact_email' => 'email|max:191|nullable',
            'state' => 'max:191|nullable',
            'county' => 'max:191|nullable'
        ];
    }

    public static function updateValidation($request)
    {
        return [
            'name' => 'max:191|required|unique:teams,name,'.$request->route('team'),
            'category_id' => 'integer|exists:categories,id|max:4294967295|required',
            'primary_contact_name' => 'max:191|required',
            'primary_contact_phone' => 'max:191|nullable',
            'primary_contact_email' => 'email|max:191|nullable',
            'state' => 'max:191|nullable',
            'county' => 'max:191|nullable'
        ];
    }

    

    
    
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id')->withTrashed();
    }
    
    
}
