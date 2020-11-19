<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use RichanFongdasen\EloquentBlameable\BlameableTrait;

class Item extends Model
{
    use HasFactory, BlameableTrait;

    protected $hidden = [
        'id','created_at','updated_at'
    ];

    public function checklist()
    {
        return $this->belongsTo('App\Models\Checklist');
    }
}
