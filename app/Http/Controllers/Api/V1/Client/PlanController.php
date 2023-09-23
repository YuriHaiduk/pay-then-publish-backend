<?php

namespace App\Http\Controllers\Api\V1\Client;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\Admin\PlanResource;
use App\Repositories\PlanRepository;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PlanController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(PlanRepository $planRepository): ResourceCollection
    {
        $plans = $planRepository->getActivePlans();
        return PlanResource::collection($plans);
    }
}
