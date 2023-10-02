<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $guarded = ["id" , "createdAt","updatedAt"];
    public $table = 'events';

    public function scopeActive($query) {
        return $query->where([["active" , true]]);
    }
}

