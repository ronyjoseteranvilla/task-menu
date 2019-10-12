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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function store(Request $request, $menu)
    {
        $menu = Menu::find($menu);
        try {
            $response = $this->interateMenuItems($request->all(), 1, '', $menu->id, $menu->max_depth, $menu->max_children);
        } catch (\Throwable $th) {
            return $th;
        }
        $items = Item::with('children')->where('menu_id', $menu->id)->where('parent_id', null)->orderBy('id','ASC')->get();
        return response()->json($items);
    }

    /**
     * Interate the items array and inserts it and it's children
     *
     * @param  array $data         comment request->all data
     * @param  mixed $level        comment level where the item is on the tree
     * @param  mixed $parent_id    comment item parent id
     * @param  mixed $menu_id      comment menu if where the item belongs
     * @param  mixed $max_depth    comment menu max depth
     * @param  mixed $max_children comment menu max child
     * @return boolean
     */
    public function interateMenuItems($data, $level, $parent_id, $menu_id, $max_depth, $max_children): bool
    {
        $aux_parentID = '';
        foreach ($data as $index1 => $node) {
            foreach ($node as $index => $value) {
                if ($index === "children") {
                    $nextLevel = $level + 1;
                    if ($nextLevel <= $max_depth) {
                        $val = $this->interateMenuItems($value, $nextLevel, $aux_parentID, $menu_id, $max_depth, $max_children);
                    }
                } else if ($index == 'field') {
                    $item = new Item();
                    $item->field = $node['field'];
                    $item->menu_id = $menu_id;
                    $item->level = $level;
                    $item->parent_id = ($parent_id != '') ? $parent_id : null;
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
     * @param  mixed $menu
     * 
     * @return \Illuminate\Http\Resources\Json\JsonResource;
     */
    public function show($menu)
    {
        $items = Item::with('children')->where('menu_id', $menu)->where('parent_id', null)->orderBy('id','ASC')->get();
        return response()->json($items);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  mixed $menu comment Menu ID 
     * 
     * @return \Illuminate\Http\Response
     */
    public function destroy($menu)
    {
        $deletedRows = Item::where('menu_id', $menu)->delete();
        return new Response('Deleted');
    }
}
