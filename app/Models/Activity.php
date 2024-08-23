<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;
    protected $fillable = ['title'];

    public function subject(){
        return $this->belongsTo(Subject::class);
    }

    public function students(){
        return $this->belongsToMany(Student::class);
    }
}
