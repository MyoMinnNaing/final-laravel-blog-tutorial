<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Comment;
use App\Mail\CommentMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCommentRequest $request)
    {

        // save comment to database
        $comment = new Comment();
        $comment->content = $request->content;
        $comment->user_id = Auth::id();
        $comment->article_id = $request->article_id;
        if ($request->has("parent_id")) {
            $comment->parent_id = $request->parent_id;
        }
        $comment->save();

        // seding email testing
        // comment လာပေးရင် ဘယ် article ကို  ဘယ် account (loginUser) က comment ပေးနေလည်း ဆို article ပိုင်ရှင် ကို email ပို့ပေးပါတယ်။။
        $article = Article::find($request->article_id);
        $loginUser = Auth::user()->name;
        $receiverEmail = $article->user->email;

        Mail::to($receiverEmail)->send(new CommentMail($loginUser, $article));
        // myominnaing.eng@gmail.com


        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCommentRequest $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);
        $comment->delete();

        return redirect()->back();
    }
}
