<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'field',
        'menu_id',
        'parent_id',
        'level'
    ];
}
