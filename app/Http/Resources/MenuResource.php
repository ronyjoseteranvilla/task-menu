<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MenuResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        //return parent::toArray($request);
         return [
             'id' => $this->id,
             'field' => $this->field,
             'max_depth' => $this->max_depth,
             'max_children' => $this->max_children
         ];
    }
}
