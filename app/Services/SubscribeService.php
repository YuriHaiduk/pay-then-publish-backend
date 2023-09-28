<?php

namespace App\Services;

use App\Http\Resources\Api\V1\Client\SubscriptionResource;
use App\Repositories\SubscriptionRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class SubscribeService
{

    protected FakePaymentService $paymentService;
    protected SubscriptionRepository $subscriptionRepository;

    public function __construct(FakePaymentService $paymentService, SubscriptionRepository $subscriptionRepository)
    {
        $this->paymentService = $paymentService;
        $this->subscriptionRepository = $subscriptionRepository;
    }

    public function subscribe(int $planId, int $userPrice): JsonResponse|SubscriptionResource
    {
        $user = Auth::user();
        $userId = $user->id;

        if (!$this->paymentService->makePayment($planId, $userPrice)) {
            return response()->json(
                ['errors' => 'Payment failed'],
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        if ($user->hasActiveSubscription()) {
            return response()->json(
                ['errors' => 'You already have an active subscription.'],
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        $subscription = $this->subscriptionRepository->createSubscription($userId, $planId);

        return SubscriptionResource::make($subscription);
    }

}
