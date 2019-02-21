<?php

// CommentController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
use App\Post;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller {

  public function store(Request $request) {
    $validator = Validator::make($request->all(), [
          'comment_body' => 'required',
    ]);
    if ($validator->fails()) {
      return redirect()->back()->withErrors($validator->errors(), 'commentErrors')->withInput($request->all());
    } else {
      try {
        $comment = new Comment;
        $comment->body = $request->get('comment_body');
        $comment->user()->associate($request->user());
        $post = Post::find($request->get('post_id'));
        $post->comments()->save($comment);
        return back();
      } catch (\Exception $ex) {
        return redirect()->back()->withErrors($ex->getMessage(), 'error');
      }
    }
  }

  public function replyStore(Request $request) {
    $validator = Validator::make($request->all(), [
          'comment_body' => 'required',
    ]);
    if ($validator->fails()) {
      return redirect()->back()->withErrors($validator->errors(), 'replyErrors')->withInput($request->all());
    } else {
      try {
        $reply = new Comment();
        $reply->body = $request->get('comment_body');
        $reply->user()->associate($request->user());
        $reply->parent_id = $request->get('comment_id');
        $post = Post::find($request->get('post_id'));
        $post->comments()->save($reply);
        return back();
      } catch (\Exception $ex) {
        return redirect()->back()->withErrors($ex->getMessage(), 'error');
      }
    }
  }

}
