<?php

namespace App\Http\Controllers\Api\V1\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Client\StorePostRequest;
use App\Http\Resources\Api\V1\Client\PostResource;
use App\Models\Post;
use App\Repositories\PostRepository;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{

    protected $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    /**
     * Handle the incoming request.
     */
    public function index(): ResourceCollection
    {
        $posts = $this->postRepository->getPostsByUserId(Auth::id());
        return PostResource::collection($posts);
    }

    public function store(StorePostRequest $request): JsonResponse|PostResource
    {
        $postData = $request->validated();
        $user = $request->user();
        $userId = $user->id;

        if ($user->hasActiveSubscription()) {

            $post = $this->postRepository->createPost($postData, $userId);
            return PostResource::make($post);

        }

        return response()->json(
            ['errors' => 'You do not have any active subscription yet.'],
            Response::HTTP_UNPROCESSABLE_ENTITY
        );

    }

    public function activate($id): JsonResponse|PostResource
    {
        $user = auth()->user();
        $post = $this->postRepository->findPostById($id);

        if (!$user->hasActiveSubscription()) {
            return response()->json(
                ['errors' => 'You need an active subscription to activate a post.'],
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        if ($post->user_id != $user->id) {
            return response()->json(
                ['errors' => 'You can activate only your own posts.'],
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        $activeSubscription = $user->activeSubscription();

        $activatedPosts = $user->activatedPosts();

        if ($activatedPosts >= $activeSubscription->plan->amount) {
            return response()->json(
                ['message' => 'You have reached your post limit for this subscription and cannot update more posts.'],
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        $this->postRepository->activatePost($post);

        return PostResource::make($post);
    }

}
