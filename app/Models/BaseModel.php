<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    use HasFactory;

    public function newEloquentBuilder($query)
    {
        return new \App\Builders\BaseBuilder($query);
    }
}
