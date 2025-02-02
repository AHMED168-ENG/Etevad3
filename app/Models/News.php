<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $guarded = ["id"];
    public function scopeActive($query) {
        return $query->where([["active" , true]]);
    }
}
