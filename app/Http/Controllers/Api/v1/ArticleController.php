<?php namespace App\Http\Controllers\Api\v1;
use DB;
use App\User;
use App\Article;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
   
    public function store(Request $request)
    {
      $data =  Article::create($request->all());

        return response()->json([
            'message' => 'success!',
            'data'  => $data
          ], 200);
    }

    public function get()
    {
      $data = Article::all();
     
        return response()->json([
            'message' => 'success!',
            'data'  => $data,
          ], 200);
    }

    public function delete(Request $request)
    {   
      $data = Article::find($request->input('article_id'))->delete();
          return response()->json([
            'message' => 'success!',
            'data'  => $data
          ], 200);
    }

   

}