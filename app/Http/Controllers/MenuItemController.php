<?php

namespace App\Http\Controllers;
use App\Http\Resources\MenuResource;
use App\Menu;
use App\Item;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\Resources\Json\JsonResource;

class MenuItemController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $menu)
    {
        $menu = Menu::find($menu);        
        try {
            $response = $this->interateMenuItems($request->all(), 1, '', $menu->id, $menu->max_depth, $menu->max_children); 
        } catch (\Throwable $th) {
            return $th;
        }
        return response()->json($request->all());        
    }

    /**
     * Interate the items array and inserts it and it's children
     *
     * @param [type] $data comment request->all data
     * @param [type] $level comment level where the item is on the tree
     * @param [type] $parent_id comment item parent id
     * @param [type] $menu_id comment menu if where the item belongs
     * @return boolean
     */
    public function interateMenuItems($data, $level, $parent_id, $menu_id, $max_depth, $max_children): bool
    {
        $aux_parentID = '';
        foreach ($data as $index1 => $node) {
            foreach ($node as $index => $value) {
                if($index === "children"){
                    $val = $this->interateMenuItems($value, $level + 1, $aux_parentID, $menu_id, $max_depth, $max_children );
                }else if($index=='field'){
                    $item = new Item();
                    $item->field = $node['field'];
                    $item->menu_id = $menu_id;
                    $item->level = $level;
                    $item->parent_id = ($parent_id != '')?$parent_id: null;
                    $item->save(); 
                    $aux_parentID = $item->id;                   
                }
            }
        }

        return true;
    }

    /**
     * Display the specified resource.
     *
     * @param  mixed  $menu
     * @return \Illuminate\Http\Response
     */
    public function show($menu)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  mixed  $menu comment Menu ID 
     * @return \Illuminate\Http\Response
     */
    public function destroy($menu)
    {
        $deletedRows = Item::where('menu_id', $menu)->delete();
        return new Response('Deleted');
    }
}
