<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Mixed_;

class Item extends Model
{
    protected $fillable = [
        'field',
        'menu_id',
        'parent_id',
        'level'
    ];

    public function children()
    {
        return $this->hasMany('App\Item', 'parent_id', 'id')->with('children');
    }


     public function scopeId($query, $id){
         return $query->where('id', $id);
     }

     public function scopeMenuID($query, $menu_id){
         return $query->where('menu_id', $menu_id);
     }

     public function scopegetItems($query, $itemID){
        return $query->Id($itemID)->with('children')->get();
     }

     public function scopeDestroyByMenu($query, $menuID){
         return $query->where('menu_id', $menuID)->delete();
     }
}
