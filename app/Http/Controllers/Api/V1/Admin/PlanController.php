<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Admin\StorePlanRequest;
use App\Http\Resources\Api\V1\Admin\PlanResource;
use App\Repositories\PlanRepository;

class PlanController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(StorePlanRequest $request, PlanRepository $planRepository): PlanResource
    {
        $planData = $request->validated();
        $plan = $planRepository->createPlan($planData);

        return PlanResource::make($plan);
    }
}
