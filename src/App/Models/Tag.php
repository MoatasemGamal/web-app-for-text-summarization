<?php
namespace App\Models;

use Core\Bases\BaseModel;


class Tag extends BaseModel
{
    protected static array $attributes = [
        'name',
    ];

    public function posts()
    {
        return $this->manyToMany(Post::class);
    }
}