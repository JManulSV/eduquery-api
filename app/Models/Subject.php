<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function classroom(){
        return $this->belongsTo(Classroom::class);
    }

    public function activities(){
        return $this->hasMany(Activity::class);
    }

    public function sheets(){
        return $this->hasMany(Sheet::class);
    }
}
