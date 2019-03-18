<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class FaqCategory
 *
 * @package App
 * @property string $title
*/
class FaqCategory extends Model
{
    
    protected $fillable = ['title'];
    

    public static function storeValidation($request)
    {
        return [
            'title' => 'max:191|required'
        ];
    }

    public static function updateValidation($request)
    {
        return [
            'title' => 'max:191|required'
        ];
    }

    

    
    
    
}
