<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = [
        'field',
        'max_depth',
        'max_children'
    ];

    
}
