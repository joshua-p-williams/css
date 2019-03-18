<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class FaqQuestion
 *
 * @package App
 * @property string $category
 * @property text $question_text
 * @property text $answer_text
*/
class FaqQuestion extends Model
{
    
    protected $fillable = ['question_text', 'answer_text', 'category_id'];
    

    public static function storeValidation($request)
    {
        return [
            'category_id' => 'integer|exists:faq_categories,id|max:4294967295|required',
            'question_text' => 'max:65535|required',
            'answer_text' => 'max:65535|required'
        ];
    }

    public static function updateValidation($request)
    {
        return [
            'category_id' => 'integer|exists:faq_categories,id|max:4294967295|required',
            'question_text' => 'max:65535|required',
            'answer_text' => 'max:65535|required'
        ];
    }

    

    
    
    public function category()
    {
        return $this->belongsTo(FaqCategory::class, 'category_id');
    }
    
    
}
