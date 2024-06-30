<?php
namespace App\Models;

use Core\Bases\BaseModel;
use Core\Bases\SoftDeletesTreat;
use Core\Bases\TimeStampsTrait;

class ApiSummary extends BaseModel
{
    protected static string $table = 'api_summaries';
    protected static array $attributes = [
        'file',
        'text',
        'cleaned_text',
        'summary',
        'model',
        'api_id',
        'feedback'
    ];

    public function setfeedbackAttribute($v)
    {
        $value = filter_var($v, FILTER_VALIDATE_BOOLEAN);
        $this->feedback = $value ? 1 : 0;
    }

    use TimeStampsTrait;

    public function author()
    {
        return $this->belongsTo(Api::class);
    }
}