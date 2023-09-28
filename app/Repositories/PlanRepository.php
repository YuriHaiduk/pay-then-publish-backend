<?php

namespace App\Repositories;

use App\Models\Plan;
use Illuminate\Pagination\LengthAwarePaginator;

class PlanRepository
{
    public function getActivePlans(): LengthAwarePaginator
    {
        return Plan::where('is_active', true)->paginate();
    }

    public function createPlan(array $planData): Plan
    {
        return Plan::create($planData);
    }

    public function findPlanById(int $planId): Plan
    {
        return Plan::find($planId);
    }

}
