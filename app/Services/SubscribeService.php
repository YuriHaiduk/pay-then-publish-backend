<?php

namespace App\Services;

use App\Http\Resources\Api\V1\Client\SubscriptionResource;
use App\Models\Subscription;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class SubscribeService
{

    protected $paymentService;

    public function __construct(FakePaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function subscribe(int $planId, int $userPrice): JsonResponse|SubscriptionResource
    {
        $user = Auth::user();

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

        $subscription = Subscription::create([
            'user_id' => Auth::id(),
            'plan_id' => $planId,
            'ends_at' => Carbon::now()->addDays(Subscription::EXPIRATION_DAYS),
        ]);

        return SubscriptionResource::make($subscription);
    }

}
