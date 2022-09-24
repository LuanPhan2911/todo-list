<?php

namespace App\Http\Controllers;

use App\Http\Requests\IndexCommentRequest;
use App\Models\Comment;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\StoreReplyCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Models\Post;
use Illuminate\Support\Facades\Request;
use Illuminate\Database\Eloquent\Builder;

class CommentController extends Controller
{
    use ResponseTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(IndexCommentRequest $request)
    {
        $post_id = $request->post_id;
        $comments = Comment::query()
            ->whereHasMorph(
                'commentable',
                [Post::class],
                function (Builder $query) use ($post_id) {
                    $query->where([
                        'id' => $post_id,
                    ]);
                }
            )
            ->where([
                'parent_id' => null
            ])
            ->get();
        return $this->success($comments);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCommentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCommentRequest $request)
    {
        $message = $request->message;
        $user_id = $request->user_id;
        $post_id = $request->post_id;
        $comment = new Comment([
            'message' => $message,
            'user_id' => $user_id,

        ]);
        $post = Post::find($post_id);
        $post->comments()->save($comment);
        return $this->success($comment);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCommentRequest  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCommentRequest $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        //
    }

    public function replyStore(StoreReplyCommentRequest $request)
    {
        $message = $request->message;
        $user_id = $request->user_id;
        $post_id = $request->post_id;
        $parent_id = $request->parent_id;

        $reply = new Comment([
            'message' => $message,
            'user_id' => $user_id,
        ]);
        $reply->parent_id = $parent_id;
        $post = Post::find($post_id);
        $post->comments()->save($reply);
        return $this->success($reply);
    }
}
