<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\User;
use App\Http\Resources\UserResource;

class OrderResource extends JsonResource
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
            'order_id' => $this->order_id,
            'email' => $this->email,
            'products' => json_decode($this->products),
            'name' => $this->name,
            'phone' => $this->phone_number,
            'address' => $this->shipping_address,
            'customer' => new UserResource(User::find($this->customer_id)),
            'grand_total' => $this->grand_total,
            'shipping_address' => $this->shipping_address,
            'status' => $this->status,
            'orderHistory' => $this->orderHistory,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
