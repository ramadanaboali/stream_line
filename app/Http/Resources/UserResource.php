<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request)
    {
        $data =[];
        $data['id']         = $this->id;
        $data['name']       = $this->name;
        $data['email']      = $this->email;
        $data['phone']      = $this->phone;
        $data['image'] = $this->photo;
        return $data;
    }

    public function with($request)
    {
        return [
            'version' => '1.0',
            'success' => true,
            'status'  => 200
        ];
    }
}
