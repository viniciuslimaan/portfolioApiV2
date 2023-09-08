<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Academic extends Model
{
    use HasFactory;

    protected $table = 'academics';

    const SEMESTER = ['one', 'two', 'three', 'four', 'five', 'six'];

    protected $fillable = [
        'name',
        'semester',
        'image',
        'description',
    ];
}
