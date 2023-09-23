<?php

namespace App\Repositories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Builder;

class PostRepository
{
    public function getPosts()
    {
        return Post::with('user')
            ->where('is_active', true)
            ->when(request('author'), function (Builder $query) {
                $query->where('user_id', request('author'));
            })
            ->paginate();
    }

    public function getPostsByUserId($userId)
    {
        return Post::with('user')
            ->where('user_id', $userId)
            ->paginate();
    }
    
}
