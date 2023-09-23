<?php

namespace App\Http\Controllers\Api\V1\Public;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\Client\PostResource;
use App\Repositories\PostRepository;

class PostController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(PostRepository $postRepository)
    {
        $posts = $postRepository->getPosts();
        return PostResource::collection($posts);
    }
}
