<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Post\UpdatePostRequest;
use App\Http\Requests\Api\Post\StorePostRequest;
use App\Http\Resources\Api\PostResource;
use Illuminate\Container\Container;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Post;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        $posts = Post::latest()->getFiveAnswers()->paginate();
        return PostResource::collection($posts);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StorePostRequest $request
     * @return PostResource
     */
    public function store(StorePostRequest $request)
    {
        $post = $request->user()->posts()->create([
            'title' => $request->title,
            'message' => $request->message
        ]);
        return PostResource::make($post);
    }

    /**
     * Display the specified resource.
     *
     * @param $post
     * @return PostResource
     */
    public function show(Post $post)
    {
        return PostResource::make($post->getFiveAnswers());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdatePostRequest $request
     * @param $post
     * @return PostResource
     */
    public function update(UpdatePostRequest $request, $post)
    {
        $post = $request->user()->posts()->findOrFail($post);
        $post->update([
            'title' => $request->title,
            'message' => $request->message,
        ]);
        return PostResource::make($post);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param $post
     * @return array
     */
    public function destroy(Request $request, $post)
    {
        $post = $request->user()->posts()->findOrFail($post);
        $post->delete();
        return ['status' => 'ok'];
    }
}
