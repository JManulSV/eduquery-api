<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Student extends Model
{
    use HasFactory;

    protected $incrementing = false;
    protected $keytype = 'string';

    protected $fillable = ['id', 'name'];

    protected static function boot(){
        parent::boot();

        static::creating(function ($student){
            if (empty($student->id)) {
                $student->id = self::generateUniqueId();
            }
        });
    }

    private static function generateUniqueId(){
        do {
            $id = Str::upper(Str::random(8));
        } while (self::where('id', $id)->exists());
        return $id;
    }

    public function classroom(){
        return $this->BelongsTo(Classroom::class);
    }

    public function activities(){
        return $this->belongsToMany(Activity::class);
    }
}
