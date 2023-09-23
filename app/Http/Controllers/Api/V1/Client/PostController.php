<?php

namespace App\Http\Controllers\Api\V1\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Client\ChangePostStatusRequest;
use App\Http\Requests\Api\V1\Client\StorePostRequest;
use App\Http\Resources\Api\V1\Client\PostResource;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function index(): ResourceCollection
    {
        $posts = Post::with('user')
            ->where('user_id', Auth::id())
            ->paginate();
        return PostResource::collection($posts);
    }

    public function store(StorePostRequest $request): JsonResponse|PostResource
    {
        $postData = $request->validated();
        $user = $request->user();

        if ($user->hasActiveSubscription()) {

            $post = Post::create([
                'user_id' => $user->id,
                'title' => $postData['title'],
                'content' => $postData['content'],
                'is_active' => false,
            ]);

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
        $post = Post::findOrFail($id);

        if (!$user->hasActiveSubscription()) {
            return response()->json(['message' => 'You need an active subscription to activate a post.']);
        }

        $activeSubscription = $user->activeSubscription();

        $activatedPosts = $user->activatedPosts();

        if ($activatedPosts >= $activeSubscription->plan->amount) {
            return response()->json(['message' => 'You have reached your post limit for this subscription and cannot update more posts.']);
        }

        $post->update([
            'is_active' => true,
            'activation_date' => Carbon::now()
        ]);

        return PostResource::make($post);
    }

}
