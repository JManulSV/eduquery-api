<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Classroom extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'user_id'];
    protected $visible = ['id', 'name', 'description'];
    protected $keyType = 'string';
    public $incrementing = false; 

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = (string) Str::uuid(); // Generate UUID when creating
        });
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function students(){
        return $this->hasMany(Student::class);
    }

    public function subjects(){
        return $this->hasMany(Subject::class);
    }

    public function sheet(){
        return $this->hasOne(Sheet::class);
    }
}
