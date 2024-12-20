<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function Sheet(){
        $this->belongsTo(Sheet::class);
    }

    public function Subject(){
        $this->belongsTo(Subject::class);
    }
}
