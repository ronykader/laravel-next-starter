<?php

namespace App\Http\Resources\v1;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
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
            'account_id' => $this->account_id,
            'user_id' => $this->user_id,
            'category_id' => $this->category_id,
            'sub_category_id' => $this->sub_category_id,
            'amount' => $this->amount,
            'transaction_date' => Carbon::parse($this->transaction_date)->toDateTimeString(),
            'type' => $this->type,
            'note' => $this->note,
            'images' => $this->images ?? null,
            'status' => $this->status,
            'created_at' => Carbon::parse($this->created_at)->toDateTimeString(),
            'updated_at' => Carbon::parse($this->updated_at)->toDateTimeString(),
        ];
    }
}
