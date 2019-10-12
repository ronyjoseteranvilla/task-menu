<?php

namespace App\Http\Controllers;

use App\Http\Resources\ItemCollection;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Item;

class ItemChildrenController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return Illuminate\Http\Resources\Json\JsonResource
     */
    public function store(Request $request, $item)
    {
        $item = Item::find($item);
        try {
            $response = $this->interateItems($request->all(), 1, $item->id);
        } catch (\Throwable $th) {
            return $th;
        }
        $items = Item::Id($item)->with('children')->get();
        return response()->json($items);
    }

    /**
     * Undocumented function
     *
     * @param  [type] $data
     * @param  [type] $level
     * @param  [type] $parent_id
     * @param  [type] $menu_id
     * @return boolean
     */
    public function interateItems($data, $level, $parent_id): bool
    {
        $aux_parentID = '';
        foreach ($data as $index1 => $node) {
            foreach ($node as $index => $value) {
                if ($index === "children") {
                    $val = $this->interateItems($value, $level + 1, $aux_parentID);
                } else if ($index == 'field') {
                    $item = new Item();
                    $item->field = $node['field'];
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
     * @param  mixed $item
     * @return use Illuminate\Http\Resources\Json\JsonResource;
     */
    public function show($item)
    {
        //$items = Item::with('children')->where('id', $item)->get();
        $items = Item::Id($item)->with('children')->get();
        return response()->json($items);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  mixed $item
     * @return \Illuminate\Http\Response
     */
    public function destroy($item)
    {
        $parent = Item::findOrFail($item);
        $idArray = $this->getChildren($parent);
        array_push($idArray, $item);
        Item::destroy($idArray);
        return new Response('deleted');
    }

    /**
     * Transform all the items id into array
     *
     * @param  [type] $items
     * @return void
     */
    private function getChildren($items)
    {
        $ids = [];
        foreach ($items->children as $item) {
            $ids[] = $item->id;
            $ids = array_merge($ids, $this->getChildren($item));
        }
        return $ids;
    }
}
