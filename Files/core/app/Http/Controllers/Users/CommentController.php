<?php

namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Comment as Comment;
use Auth;

class CommentController extends Controller
{
    public function store(Request $request) {
      $comment = new Comment;
      $comment->comment = $request->comment;
      $comment->user_id = Auth::user()->id;
      $comment->post_id = $request->postID;
      $comment->save();
      return $comment;
    }

    public function edit(Request $request) {
      $comment = Comment::find($request->commentID);
      return $comment;
    }

    public function update(Request $request) {
      $comment = Comment::find($request->commentID);
      $comment->comment = $request->editCommentInput;
      $comment->save();
      return "success";
    }

    public function delete(Request $request) {
      $comment = Comment::find($request->commentID);
      $comment->delete();
      return 'success';
    }
}
