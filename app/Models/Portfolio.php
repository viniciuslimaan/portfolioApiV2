<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    use HasFactory;

    protected $table = 'portfolios';

    const TYPE = ['design', 'prototype', 'web', 'mobile'];

    protected $fillable = [
        'name',
        'type',
        'image',
        'deploy',
        'github',
        'figma',
    ];
}
