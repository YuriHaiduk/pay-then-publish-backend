<?php

namespace App\Http\Resources\Api\V1\Client;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubscriptionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'user_name' => $this->user->name,
            'plan_name' => $this->plan->name,
            'created_at' => $this->created_at->diffForHumans(),
            'ends_at' => $this->ends_at->toDateTimeString()
        ];
    }
}
