<?php
/**
 * @file
 * Description this is the Menu Controller to create a new controller
 */

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
     * @param \Illuminate\Http\Request $request comment request data
     *
     * @return App\Http\Resources\MenuResource
     */
    public function store(Request $request): MenuResource
    {
        $request->validate(
            [
                 'field'    => 'required',
                 'max_depth'     => 'required',
                 'max_children'         => 'required'
                 ]
        );
        $menu = Menu::create($request->all());
        return new MenuResource($menu);
    }

    /**
     * Display the specified resource.
     *
     * @param mixed $menu comment Menu ID
     *
     * @return App\Http\Resources\MenuResource
     */
    public function show($menu): MenuResource
    {
        $menu = Menu::find($menu);
        return new MenuResource($menu);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request comment request data
     * @param mixed                    $menu    comment Menu ID
     *
     * @return App\Http\Resources\MenuResource
     */
    public function update(Request $request, $menu): MenuResource
    {
        $menuElement = Menu::find($menu);
        $menuElement->update($request->all());
        return new MenuResource($menuElement);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param mixed $menu comment Menu ID
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($menu): Response
    {
        $menuElement = Menu::find($menu);
        $menuElement->delete();
        return new Response('Deleted');
    }
}
