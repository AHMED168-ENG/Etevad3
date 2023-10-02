<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact_us extends Model
{
    use HasFactory;

    protected $guarded = ["id"];
    public function scopeSeen($query) {
        return $query->where([["is_seen" , true]]);
    }
    public function scopeNotSeen($query) {
        return $query->where([["is_seen" , false]]);
    }
}
