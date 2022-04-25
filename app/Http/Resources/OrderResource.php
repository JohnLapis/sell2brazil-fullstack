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
        $date = $this->date;
        return [
            'OrderId' => $this->id,
            'OrderCode' => substr($date, 0, strlen($date)-3) . '-' . $this->id,
            'OrderDate' => $date,
            'TotalAmountWithoutDiscount' => $this->total + $this->discount,
            'TotalAmountWithDiscount' => $this->total,
        ];
    }
}
