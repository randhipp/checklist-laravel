<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use RichanFongdasen\EloquentBlameable\BlameableTrait;
use Spatie\Activitylog\Traits\LogsActivity;

class Checklist extends Model
{
    use HasFactory, BlameableTrait, LogsActivity;

    protected static $logAttributes = ['*'];

    protected $hidden = [
        'id','created_at','updated_at'
    ];

    public function items()
    {
        return $this->hasMany('App\Models\Item');
    }
}
