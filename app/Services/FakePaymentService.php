<?php

namespace App\Services;

use App\Models\Plan;

class FakePaymentService
{
    public function makePayment(int $planId, int $userPrice)
    {
        $plan = Plan::find($planId);

        if (!$plan) {
            return false;
        }

        return $userPrice === (int) $plan->price;
    }
}
