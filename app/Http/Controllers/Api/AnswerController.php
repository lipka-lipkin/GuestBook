<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Answer\StoreAnswerRequest;
use App\Http\Requests\Api\Answer\UpdateAnswerRequest;
use App\Http\Resources\Api\AnswerResource;
use App\Post;
use Exception;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class AnswerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Post $post
     * @return AnonymousResourceCollection
     */
    public function index(Post $post)
    {
        $answers = $post->answers()->with('user.avatar')->latest()->paginate();
        return AnswerResource::collection($answers);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreAnswerRequest $request
     * @param $post
     * @return AnswerResource
     */
    public function store(StoreAnswerRequest $request, Post $post)
    {
        $answer = $post->answers()->create([
            'message' => $request->message,
            'user_id' => $request->user()->id
        ]);
        $post->user->sendPush([
            'status' => 'ok',
            'type' => 'answer-store',
            'data' => AnswerResource::make($answer)
        ]);
        return AnswerResource::make($answer->load('user'));
    }

    /**
     * Display the specified resource.
     *
     * @param $post
     * @param $answer
     * @return AnswerResource
     */
    public function show(Post $post, $answer)
    {
        $answer = $post->answers()->findOrFail($answer);
        return AnswerResource::make($answer->load('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateAnswerRequest $request
     * @param $post
     * @param $answer
     * @return AnswerResource|ResponseFactory|Response|void
     */
    public function update(UpdateAnswerRequest $request, Post $post, $answer)
    {
        $answer = $post->answers()->findOrFail($answer);
        $user_id = $request->user()->id;
        if ($answer->user_id == $user_id or $post->user_id == $user_id)
        {
            $answer->update([
                'message' => $request->message
            ]);
            $post->user->sendPush(
                [
                    'status' => 'ok',
                    'type' => 'answer-update',
                    'data' => AnswerResource::make($answer)
                ]);
            return AnswerResource::make($answer->load('user'));
        }
        else return response(['message' => 'access denied'], 403);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param Post $post
     * @param $answer
     * @return array|ResponseFactory|Response|void
     * @throws Exception
     */
    public function destroy(Request $request, Post $post, $answer)
    {
        $answer = $post->answers()->findOrFail($answer);
        $user_id = $request->user()->id;
        if ($answer->user_id == $user_id or $post->user_id == $user_id)
        {
            $answer->delete();
            $post->user->sendPush($post->id,
                [
                    'status' => 'ok',
                    'type' => 'answer-destroy',
                    'data' => AnswerResource::make($answer)
                ]);
            return ['status' => 'ok'];
        }
        else return response(['message' => 'access denied'], 403);
    }
}
