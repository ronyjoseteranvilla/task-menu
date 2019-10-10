<?php

namespace App\Http\Controllers;

use App\Http\Resources\ItemResource;
use App\Item;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ItemController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): ItemResource
    {
        $item = Item::create($request->all());
        return new ItemResource($item);
    }

    /**
     * Display the specified resource.
     *
     * @param  mixed $item
     * @return \Illuminate\Http\Response
     */
    public function show($item): ItemResource
    {
        $item = Item::find($item);
        return new ItemResource($item);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  mixed                    $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $item): ItemResource
    {
        $itemElement = Item::find($item);
        $itemElement->update($request->all());
        return new ItemResource($itemElement);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  mixed $item
     * @return \Illuminate\Http\Response
     */
    public function destroy($item): Response
    {
        $itemElement = Item::find($item);
        $itemElement->delete();
        return new Response('Deleted');
    }
}
