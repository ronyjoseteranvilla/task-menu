<?php

namespace App\Http\Controllers;

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
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $item)
    {
        $item = Item::find($item);      
        try {
            $response = $this->interateItems($request->all(), 1, $item->id); 
        } catch (\Throwable $th) {
            return $th;
        }
        return response()->json($request->all()); 
    }

    /**
     * Undocumented function
     *
     * @param [type] $data
     * @param [type] $level
     * @param [type] $parent_id
     * @param [type] $menu_id
     * @return boolean
     */
    public function interateItems($data, $level, $parent_id): bool
    {
        $aux_parentID = '';
        foreach ($data as $index1 => $node) {
            foreach ($node as $index => $value) {
                if($index === "children") {
                    $val = $this->interateItems($value, $level + 1, $aux_parentID);
                }else if($index=='field') {
                    $item = new Item();
                    $item->field = $node['field'];
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
     * @param  mixed $item
     * @return \Illuminate\Http\Response
     */
    public function show($item)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  mixed $item
     * @return \Illuminate\Http\Response
     */
    public function destroy($item)
    {
        //
    }
}
