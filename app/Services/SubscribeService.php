<?php

namespace App\Services;

use App\Http\Resources\Api\V1\Client\SubscriptionResource;
use App\Models\Subscription;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class SubscribeService
{
    public function subscribe(int $planId): JsonResponse|SubscriptionResource
    {
        $user = Auth::user();

        if ($user->hasActiveSubscription()) {
            return response()->json(
                ['errors' => 'You already have an active subscription.'],
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        $subscription = Subscription::create([
            'user_id' => Auth::id(),
            'plan_id' => $planId,
            'ends_at' => Carbon::now()->addDays(Subscription::EXPIRATION_DAYS),
        ]);

        return SubscriptionResource::make($subscription);
    }

}
