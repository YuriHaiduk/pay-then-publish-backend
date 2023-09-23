<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Admin\StorePlanRequest;
use App\Http\Resources\Api\V1\Admin\PlanResource;
use App\Models\Plan;

class PlanController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(StorePlanRequest $request)
    {
        $planData = $request->validated();
        $plan = Plan::create($planData);

        return PlanResource::make($plan);
    }
}
