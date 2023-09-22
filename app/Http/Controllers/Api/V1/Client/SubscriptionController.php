<?php

namespace App\Http\Controllers\Api\V1\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Client\SubscribeRequest;

class SubscriptionController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(SubscribeRequest $request)
    {
        $data = $request->validated();
        dd($data);
    }
}
