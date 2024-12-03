<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\Contracts\Activity;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Device extends Model
{
    protected $guarded=[];
    
    use HasFactory, LogsActivity;

    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'name',
        'topic',
        'capacity',
    ];
    
	/**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return HasMany
     */
    public function schedule(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly([
            'name',
            'topic',
            'capacity',
        ]);
        // Chain fluent methods for configuration options
    }

    // public function tapActivity(Activity $activity, string $eventName)
    // {
    //     $activity->description = "activity.logs.message.{$eventName}";
    // }

}
