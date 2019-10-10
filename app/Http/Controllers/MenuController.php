<?php

namespace App\Http\Controllers;

use App\Http\Resources\MenuResource;
use App\Menu;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MenuController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return App\Http\Resources\MenuResource
     */
    public function store(Request $request): MenuResource
    {
        $menu = Menu::create($request->all());
        return new MenuResource($menu);
    }

    /**
     * Display the specified resource.
     * @param  mixed  $menu
     * @return \Illuminate\Http\Response
     */
    public function show($menu)
    {
        $menu = Menu::find($menu);
        return new MenuResource($menu);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $menu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $menu)
    {
        $menuElement = Menu::find($menu);
        $menuElement->update($request->all());
        return new MenuResource($menuElement);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  mixed  $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy($menu)
    {
        $menuElement = Menu::find($menu);
        $menuElement->delete();
        return new Response('Deleted');
    }
}
