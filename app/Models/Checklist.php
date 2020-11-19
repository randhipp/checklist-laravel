<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use RichanFongdasen\EloquentBlameable\BlameableTrait;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\BaseModel;
class Checklist extends BaseModel
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
