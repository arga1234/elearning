<?php namespace App\Http\Controllers\Api\v1;
use DB;
use App\Comment;
use App\User;
use App\Article;
use Carbon\Carbon;
use Illuminate\Http\Request;


  class CommentController extends Controller
  {
      public function store(Request $request)
      {
          $comment = new Comment;
          $comment->body = $request->get('comment_body');
          $comment->user()->associate($request->user());
          $post = Article::find($request->get('article_id'));
          $post->comments()->save($comment);
  
          return response()->json([
            'message' => 'success!',
            'data'  => $comment
          ], 200);
      }

      public function replyStore(Request $request)
    {
        $reply = new Comment();
        $reply->body = $request->get('comment_body');
        $reply->user()->associate($request->user());
        $reply->parent_id = $request->get('comment_id');
        $post = Article::find($request->get('article_id'));

        $post->comments()->save($reply);

        return response()->json([
          'message' => 'success!',
          'data'  => $post
        ], 200);

    }

    public function delete(Request $request)
    {
        $data = Comment::find($request->input('comment_id'))->deleteWithReplies();
        return response()->json([
          'message' => 'success!',
          'data'  => $data
        ], 200);

    }

    
  }

   

