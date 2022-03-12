<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use JetBrains\PhpStorm\Pure;


class AuthorsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $response = [
          'id' => (string)$this->id,
          'type' => 'Authors',
          'attributes' => [
                'name' => $this->name,
                'book' => $this->book,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
            ]
        ];
        return ($this->message !== null)
            ? array_merge($response, ['message' => $this->message])
            : $response;
    }
}
