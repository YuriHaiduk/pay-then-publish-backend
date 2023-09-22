<?php

namespace App\Http\Controllers\Api\V1\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Client\ChangePostStatusRequest;
use App\Http\Requests\Api\V1\Client\StorePostRequest;

class PostController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function index()
    {

    }

    public function store(StorePostRequest $request)
    {
        $data = $request->validated();
        dd($data);
    }

    public function changeStatus(ChangePostStatusRequest $request)
    {
        $data = $request->validated();
        dd($data);
    }

}
