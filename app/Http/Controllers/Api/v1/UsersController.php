<?php namespace App\Http\Controllers\Api\v1;
use DB;
use App\Users;
use App\user;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    const MODEL = "App\User";

    use RESTActions;

   
    public function test()
    {
       
       $users =  Users::with('schoolgsm')->get();

        

        return response()->json([
            'message' => 'success!',
            'school' => $users
          ], 200);
        
    }

   
    public function store(Request $request)
    {

        
        
    }

    public function registerUser(Request $request)
    {

        
        $user = new Users;
        $user->sex = $request->input('sex');
        $user->save();

        $data = Users::get();
        return $data;
    }

    private function jumlahMale(){

        $data = Users::where('sex',0)->count();
        return response()->json([
            'message' => 'Success!',
            'data'  => $user
          ], 200);
    }

    private function jumlahFemale(){

        $data = Users::where('sex',1)->count();
        return response()->json([
            'message' => 'Success!',
            'data'  => $user
          ], 200);
    }

    private function jumlahSekolahUser(){

        $data = Users::distict('school.sekolah')->count();
        return response()->json([
            'message' => 'Success!',
            'data'  => $user
          ], 200);
    }

   public function userRegisteredChart(){
    $date = "2019-03-04T10:22:53.000Z";
    $hour = Carbon::parse($date)->format('h');
    $data = DB::raw('db.users.aggregate(
        [
        { $group : {
        _id : { year: { $year: "$created_at" } , month: { $month: "$created_at" }, day: { $dayOfMonth: "$created_at" }},
        count: { $sum: 1 }
        }
        },
        { $sort: { _id: 1 } }
        
        ]
        )');


       $dataTest = Users::raw(function ($collection) {
        return $collection->aggregate([
           
            [
    
                '$group' => [
                    '_id'   => [
                        'month'  => ['$month' => '$created_at'],
                        'day'    => ['$dayOfMonth' => '$created_at'],
                        'year'   => ['$year' => '$created_at'],
                        
                    ],
                    'count' => [
                        '$sum' => 1
                    ]
                ]
            ]
        ]);
    });;
               
   return response()->json([
    'message' => $hour,
    'data'  => $dataTest
  ], 200);
    }

}