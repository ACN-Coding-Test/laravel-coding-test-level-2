<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'tittle' => $this->tittle,
            'description' => $this->description,
            'status' => $this->status,
            'project_id' => $this->project_id,
            'user_id' => $this->user_id,
            'user_details' => $this->user_detail,
            'project_details' => $this->project_detail,


        ];

    }
}
