<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checklist extends Model
{
    use HasFactory;

    protected $hidden = [
        'id','created_at','updated_at'
    ];

    public function items()
    {
        return $this->hasMany('App\Models\Item');
    }
}
