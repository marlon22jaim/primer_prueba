<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'supplierId' => $this->supplier_id,
            'amount' => $this->amount,
            'status' => $this->status,
            'billDate' => $this->billed_dated,
            'paidDate' => $this->paid_dated,
            'fechaCreacion'=> $this->created_at,
        ];
    }
}
