<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sheet extends Model
{
    use HasFactory;

    public $increment = false;
    protected $keytype = 'string';

    protected $fillable = ['id'];

    public function subject(){
        return $this->BelongsTo(Subject::class);
    }

    public function pages(){
        return $this->hasMany(Page::class);
    }
}