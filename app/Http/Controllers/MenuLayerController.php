<?php

namespace App\Http\Controllers;

use App\Http\Resources\ItemCollection;
use App\Item;
use Illuminate\Http\Request;

class MenuLayerController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  mixed  $menu comment menu ID
     * @param mixed $layer comment layer number
     * 
     * @return \Illuminate\Http\Response
     */
    public function show($menu, $layer)
    {
        $layerItems = Item::where('menu_id', $menu)->where('level', $layer)->get();
        return new ItemCollection($layerItems);
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  mixed  $menu
     * 
     * @return \Illuminate\Http\Response
     */
    public function destroy($menu)
    {
        //
    }
}
