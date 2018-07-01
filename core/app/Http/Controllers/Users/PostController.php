<?php

namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Post as Post;
use App\Comment as Comment;
use Auth;

class PostController extends Controller
{
    public function store(Request $request) {
      $post = new Post;
      $post->user_id = Auth::user()->id;
      $post->posted_on_user_id = $request->postedOnUserId;
      $post->content = $request->content;
      $post->save();
      return "success";
    }

    public function update(Request $request) {
      $post = Post::find($request->postID);
      $post->content = $request->content;
      $post->save();
      return "success";
    }

    public function edit(Request $request) {
      $post = Post::find($request->postID);
      return $post;
    }

    public function delete(Request $request) {
      $comments = Comment::where('post_id', $request->postID)->delete();
      $post = Post::find($request->postID)->delete();
      return "success";
    }
}
