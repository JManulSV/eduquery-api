<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sheet extends Model
{
    use HasFactory;

    public $increment = false;
    protected $keytype = 'string';

    protected $fillable = ['id', 'classroom_id'];

    public function classroom(){
        return $this->BelongsTo(Classroom::class);
    }

    public function pages(){
        return $this->hasMany(Page::class);
    }
}