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

    
    protected $fillable = ['name', 'use_in_tb_1', 'use_in_tb_2', 'use_in_tb_3', 'use_in_tb_4'];
        
    protected $casts = [
        'use_in_tb_1' => 'boolean',
        'use_in_tb_2' => 'boolean',
        'use_in_tb_3' => 'boolean',
        'use_in_tb_4' => 'boolean',
    ];


    public static function storeValidation($request)
    {
        return [
            'name' => 'max:191|required|unique:events,name',
            'use_in_tb_1' => 'nullable',
            'use_in_tb_2' => 'nullable',
            'use_in_tb_3' => 'nullable',
            'use_in_tb_4' => 'nullable',
        ];
    }

    public static function updateValidation($request)
    {
        return [
            'name' => 'max:191|required|unique:events,name,'.$request->route('event'),
            'use_in_tb_1' => 'nullable',
            'use_in_tb_2' => 'nullable',
            'use_in_tb_3' => 'nullable',
            'use_in_tb_4' => 'nullable',
        ];
    }

    

    
    
    
}
