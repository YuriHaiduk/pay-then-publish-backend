<?php

namespace App\Repositories;

use App\Models\Plan;

class PlanRepository
{
    public function getActivePlans()
    {
        return Plan::where('is_active', true)->paginate();
    }
}
