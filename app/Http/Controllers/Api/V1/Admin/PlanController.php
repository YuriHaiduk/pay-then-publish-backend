<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Admin\StorePlanRequest;

class PlanController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(StorePlanRequest $request)
    {
        $data = $request->validated();
        dd($data);
    }
}
