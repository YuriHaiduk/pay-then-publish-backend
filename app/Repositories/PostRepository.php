<?php

namespace App\Repositories;

use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

class PostRepository
{
    public function getPosts(): LengthAwarePaginator
    {
        return Post::with('user')
            ->where('is_active', true)
            ->when(request('author'), function (Builder $query) {
                $query->where('user_id', request('author'));
            })
            ->paginate();
    }

    public function getPostsByUserId(int $userId): LengthAwarePaginator
    {
        return Post::with('user')
            ->where('user_id', $userId)
            ->paginate();
    }

    public function findPostById(int $postId): Post
    {
        return Post::findOrFail($postId);
    }

    public function createPost(array $postData, int $userId): Post
    {
        return Post::create([
            'user_id' => $userId,
            'title' => $postData['title'],
            'content' => $postData['content'],
            'is_active' => false,
        ]);
    }

    public function activatePost(Post $post): void
    {
        $post->update([
            'is_active' => true,
            'activation_date' => Carbon::now(),
        ]);
    }

}
