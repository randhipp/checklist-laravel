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

    protected $fillable = [
        'object_domain','object_id','due','urgency','description','task_id'
    ];

    protected $hidden = [
        'id','deleted_by'
    ];

    protected $casts = [
        'is_completed' => 'boolean',
        'due' => 'datetime'
    ];

    public function items()
    {
        return $this->hasMany('App\Models\Item');
    }
}
