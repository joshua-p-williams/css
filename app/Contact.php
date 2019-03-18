<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Contact
 *
 * @package App
 * @property string $company
 * @property string $category
 * @property string $name
 * @property string $phone
 * @property string $email
 * @property string $address
*/
class Contact extends Model
{
    
    protected $fillable = ['name', 'phone', 'email', 'address', 'company_id', 'category_id'];
    

    public static function storeValidation($request)
    {
        return [
            'company_id' => 'integer|exists:contact_companies,id|max:4294967295|required',
            'category_id' => 'integer|exists:categories,id|max:4294967295|required',
            'name' => 'max:191|required',
            'phone' => 'max:191|nullable',
            'email' => 'max:191|nullable',
            'address' => 'max:191|nullable'
        ];
    }

    public static function updateValidation($request)
    {
        return [
            'company_id' => 'integer|exists:contact_companies,id|max:4294967295|required',
            'category_id' => 'integer|exists:categories,id|max:4294967295|required',
            'name' => 'max:191|required',
            'phone' => 'max:191|nullable',
            'email' => 'max:191|nullable',
            'address' => 'max:191|nullable'
        ];
    }

    

    
    
    public function company()
    {
        return $this->belongsTo(ContactCompany::class, 'company_id');
    }
    
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id')->withTrashed();
    }
    
    
}
