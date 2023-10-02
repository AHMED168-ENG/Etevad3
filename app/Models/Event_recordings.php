<?php

namespace App\Models;
use App\Models\Event;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event_recordings extends Model
{
    use HasFactory;
    protected $guarded = ["id"];
    
    public function scopeSeen($query) {
        return $query->where([["is_seen" , true]]);
    }
    public function scopeNotSeen($query) {
        return $query->where([["is_seen" , false]]);
    }

   public function event() {
        return $this->belongsTo(Event::class , "event_id");
    }
}
