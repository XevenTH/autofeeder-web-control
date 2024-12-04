<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\Contracts\Activity;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class User extends Authenticatable
{
    use HasFactory, Notifiable, LogsActivity;

    protected $guarded=[];
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

	/**
     * @return HasMany
     */
    public function device(): HasMany
    {
        return $this->hasMany(Device::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly([
            'name',
            'email',
            'phone',
            'password',
        ]);
        // Chain fluent methods for configuration options
    }

    public function tapActivity(Activity $activity, string $eventName)
    {
        $activity->log_name = "manipulation";
        // $activity->description = "activity.logs.message.{$eventName}";
        if ($eventName == "created") {
            $activity->description = "User adds a user data";
        }
        else if ($eventName == "updated") {
            $activity->description = "User changes a user data";
        }
        else if ($eventName == "deleted") {
            $activity->description = "User deletes a user data";
        } 
        else {
            $activity->description = $eventName;
        }
    }
}
