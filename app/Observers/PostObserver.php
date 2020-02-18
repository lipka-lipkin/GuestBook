<?php

namespace App\Observers;

use App\Events\PublicPush;
use App\Http\Resources\Api\PostResource;
use App\Post;

class PostObserver
{
    /**
     * Handle the post "created" event.
     *
     * @param Post $post
     * @return void
     */
    public function created(Post $post)
    {
        event(new PublicPush(Post::$publicChannel,[
            'status' => 'ok',
            'type' => 'post-store',
            'data' => PostResource::make($post)
        ]));
    }

    /**
     * Handle the post "updated" event.
     *
     * @param Post $post
     * @return void
     */
    public function updated(Post $post)
    {
        event(new PublicPush(Post::$publicChannel, [
            'status' => 'ok',
            'type' => 'post-update',
            'data' => PostResource::make($post)
        ]));
    }

    /**
     * Handle the post "deleted" event.
     *
     * @param Post $post
     * @return void
     */
    public function deleted(Post $post)
    {
        event(new PublicPush(Post::$publicChannel, [
            'status' => 'ok',
            'type' => 'post-destroy',
            'data' => PostResource::make($post)
        ]));
    }
}
