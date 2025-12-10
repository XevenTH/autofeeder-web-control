<?php

namespace App\Http\Resources;

// use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

// Ini tidak mempan/tidak bisa sama sekali entah mengapa
class ActivityResource extends JsonResource
{
    // public static $wrap = false;
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return parent::toArray($request);
        return [
            'id' => $this->id,
            'log_name' => $this->log_name,
            'description' => $this->description,
            'subject_type' => $this->subject_type,
            'event' => $this->event,
            'subject_id' => $this->subject_id,
            'causer_type' => $this->causer_type,
            'causer_id' => $this->causer_id,
            // 'causer_name' => User::where('id', $this->causer_id)->pluck('name'),
            'causer_name' => "yeet",
            'properties' => $this->properties,
            'batch_uuid' => $this->batch_uuid,
            "created_at" => (new Carbon($this->created_at))->format('Y-m-d H:i:s'),
            "updated_at" => (new Carbon($this->updated_at))->format('Y-m-d H:i:s'),
        ];
        
    }
}
