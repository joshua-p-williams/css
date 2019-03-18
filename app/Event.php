<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Event
 *
 * @package App
 * @property string $name
*/
class Event extends Model
{
    use SoftDeletes;

    
    protected $fillable = ['name'];
    

    public static function storeValidation($request)
    {
        return [
            'name' => 'max:191|required|unique:events,name'
        ];
    }

    public static function updateValidation($request)
    {
        return [
            'name' => 'max:191|required|unique:events,name,'.$request->route('event')
        ];
    }

    

    
    
    
}
