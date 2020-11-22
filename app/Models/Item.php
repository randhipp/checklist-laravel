<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use RichanFongdasen\EloquentBlameable\BlameableTrait;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\BaseModel;

class Item extends BaseModel
{
    use HasFactory, BlameableTrait, LogsActivity;

    protected static $logAttributes = ['*'];

    public $fillable = ['description'];

    protected $hidden = [
        'id','created_at','updated_at'
    ];

    protected $casts = [
        'id' => 'string',
        'is_completed' => 'boolean',
        'due' => 'string',
        // 'urgency' => 'integer'
    ];

    public function checklist()
    {
        return $this->belongsTo('App\Models\Checklist');
    }
}
