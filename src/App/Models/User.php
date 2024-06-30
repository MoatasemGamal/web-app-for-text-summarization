<?php
namespace App\Models;

use Core\Bases\BaseModel;
use Core\Bases\TimeStampsTrait;

class User extends BaseModel
{
    protected static array $attributes = [
        'name',
        'email',
        'password',
        'avatar',
        'role'
    ];
    use TimeStampsTrait;

    public function apis()
    {
        return $this->hasMany(Api::class);
    }
}