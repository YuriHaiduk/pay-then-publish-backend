<?php

namespace App\Services;

use App\Repositories\PlanRepository;

class FakePaymentService
{

    protected PlanRepository $planRepository;

    public function __construct(PlanRepository $planRepository)
    {
        $this->planRepository = $planRepository;
    }

    public function makePayment(int $planId, int $userPrice): bool
    {
        $plan = $this->planRepository->findPlanById($planId);

        if (!$plan) {
            return false;
        }

        return $userPrice === (int)$plan->price;
    }
}
