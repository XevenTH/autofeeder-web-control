<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Contracts\Activity;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Schedule extends Model
{
    protected $guarded=[];
    
    use HasFactory, LogsActivity;

    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'device_id',
        'active',
        'days',
        'time',
        'grams_per_feeding',
        'servo_seconds',
    ];
    
	/**
     * @return BelongsTo
     */
    public function device(): BelongsTo
    {
        return $this->belongsTo(Device::class);
    }    

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly([
            'device_id',
            'active',
            'days',
            'time',
            'grams_per_feeding',
            'servo_seconds',
        ]);
        // Chain fluent methods for configuration options
    }

    // public function tapActivity(Activity $activity, string $eventName)
    // {
    //     $activity->description = "activity.logs.message.{$eventName}";
    // }

}
