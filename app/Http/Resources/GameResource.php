<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GameResource extends JsonResource
{
    
    public function toArray($request)
    {
        return [
            'id' => (string)$this->id,
            'attributes' => [
                'user_id' => $this->user_id,
                'title' => $this->title,
                'genre' => $this->genre,
                'description' => $this->description,
                'release_date' => $this->release_date
            ],
            'relationships' => [
                'username' => $this->user->username,
                'usertype' => $this->user->usertype
            ]
        ];
    }
}
