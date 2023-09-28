<?php

namespace App\Repositories;

use App\Models\Subscription;
use Carbon\Carbon;

class SubscriptionRepository
{
    public function createSubscription(int $userId, int $planId): Subscription
    {
        return Subscription::create([
            'user_id' => $userId,
            'plan_id' => $planId,
            'ends_at' => Carbon::now()->addDays(Subscription::EXPIRATION_DAYS),
        ]);
    }
}
