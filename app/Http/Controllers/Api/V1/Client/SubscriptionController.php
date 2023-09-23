<?php

namespace App\Http\Controllers\Api\V1\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Client\SubscribeRequest;
use App\Services\SubscribeService;

class SubscriptionController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(SubscribeRequest $request, SubscribeService $subscribeService)
    {

        $data = $request->validated();
        $planId = (int) $data['plan_id'];
        $userPrice = (int) $data['user_price'];

        return $subscribeService->subscribe($planId, $userPrice);
    }
}
