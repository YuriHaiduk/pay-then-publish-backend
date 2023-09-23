<?php

namespace App\Http\Controllers\Api\V1\Public;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\Client\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class PostController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $posts = Post::with('user')
            ->where('is_active', true)
            ->when(request('author'), function (Builder $query) {
                $query->where('user_id', request('author'));
            })
            ->get();

        return PostResource::collection($posts);
    }
}
