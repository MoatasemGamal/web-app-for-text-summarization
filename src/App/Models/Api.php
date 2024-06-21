<?php
namespace App\Models;

use Core\Bases\BaseModel;
use Core\Bases\TimeStampsTrait;


class Api extends BaseModel
{
    protected static array $attributes = [
        'name',
        'token',
        'user_id',
        'status'
    ];
    use TimeStampsTrait;


    // public function posts()
    // {
    //     return $this->manyToMany(Post::class);
    // }
}