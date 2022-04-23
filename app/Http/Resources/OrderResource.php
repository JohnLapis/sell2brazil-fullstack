<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $order = parent::toArray($request);
        $date = $order["date"];
        return [
            'OrderId' => $order['id'],
            'OrderCode' => substr($date, 0, strlen($date)-3) . '-' . $order["id"],
            'OrderDate' => $date,
            'TotalAmountWithoutDiscount' => $order["total"] - $order["discount"],
            'TotalAmountWithDiscount' => $order["total"],
        ];
    }
}
