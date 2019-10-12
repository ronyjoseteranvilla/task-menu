<?php

namespace App\Http\Controllers;

use App\Item;
use Illuminate\Http\Resources\Json\JsonResource;

class MenuDepthController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  mixed $menu
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function show($menu)
    {
        $depth = Item::select('level as depth')->where('menu_id', $menu)->orderBy('level', 'DESC')->first();
        return response()->json($depth);
    }
}
