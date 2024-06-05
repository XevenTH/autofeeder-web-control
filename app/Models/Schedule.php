<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Schedule extends Model
{
    protected $guarded=[];
    
    use HasFactory;

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
}
