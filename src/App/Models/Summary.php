<?php
namespace App\Models;

use Core\Bases\BaseModel;
use Core\Bases\SoftDeletesTreat;
use Core\Bases\TimeStampsTrait;

class Summary extends BaseModel
{
    protected static string $table = 'summaries';
    protected static array $attributes = [
        'file',
        'text',
        'cleaned_text',
        'summary',
        'model',
        'author',
        'feedback'
    ];

    public function setfeedbackAttribute($v)
    {
        $value = filter_var($v, FILTER_VALIDATE_BOOLEAN);
        $this->feedback = $value ? 1 : 0;
    }

    use TimeStampsTrait;
    // use SoftDeletesTreat;

    // public function getTitleAttribute($v)
    // {
    //     return "TITLE FROM GET: " . $v;
    // }
    // public function tags(int $n = null)
    // {
    //     if (is_int($n) && isset($this->manyToMany(Tag::class)[$n]))
    //         return $this->manyToMany(Tag::class)[$n];

    //     return $this->manyToMany(Tag::class);
    // }

    public function author()
    {
        return $this->belongsTo(User::class);
    }
}