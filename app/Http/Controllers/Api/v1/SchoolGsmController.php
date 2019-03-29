<?php namespace App\Http\Controllers\Api\v1;
use DB;
use App\User;
use App\SchoolGsm;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SchoolGsmController extends Controller
{
   
    public function store(Request $request)
    {

        $this->validate($request, [
            'npsn' => 'required|unique:schoolGsm',
          ]);


        $longitude = floatval($request->input('bujur'));
        $latitude = floatval($request->input('lintang'));
        
        $school = new SchoolGsm;
        $school->propinsi = $request->input('propinsi');
        $school->npsn = $request->input('npsn');
        $school->kode_kab_kota = $request->input('kode_kab_kota');
        $school->kabupaten_kota = $request->input('kabupaten_kota');
        $school->kode_kec = $request->input('kode_kec');
        $school->kecamatan = $request->input('kecamatan');
        $school->sekolah = $request->input('sekolah');
        $school->kecamatan = $request->input('kecamatan');
        $school->data_id = $request->input('id');
        $school->alamat_jalan = $request->input('alamat_jalan');
        $school->status = $request->input('status');
        $school->bentuk = $request->input('bentuk');
        $school->lokasi = [$longitude,$latitude];

       
       
        $school->save();

       
        return response()->json([
            'message' => 'success!',
            'data'  => $school
          ], 201);
    }

    public function get()
    {

       $data = SchoolGsm::all();
       $school = SchoolGsm::with('user')->get();
       $user = SchoolGsm::first();
     
        return response()->json([
            'message' => 'success!',
            'data'  => $user,
            'school' => $school
          ], 200);
    }

    public function getDaerah()
    {

      
       $school = SchoolGsm::groupBy('kecamatan')->get();

     
        return response()->json([
            'message' => 'success!',
            'data'  => $school
          ], 200);
    }

    public function sekolahPerDaerah(Request $request)
    {

      
       $school = SchoolGsm::where('kecamatan',$request->input('kecamatan'))->get();

     
        return response()->json([
            'message' => 'success!',
            'data'  => $school
          ], 200);
    }

    public function delete(Request $request)
    { 

        $npsn = $request->input('npsn');
        $sekolah =  SchoolGsm::where('npsn','=',$npsn)->delete();

       
        return response()->json([
            'message' => 'success!',
            'data'  => $sekolah
          ], 200);
    }

    public function dataGraphMap()
    { 

        $sekolah =  SchoolGsm::select('sekolah','lokasi')->get();

       
        return response()->json([
            'message' => 'success!',
            'data'  => $sekolah
          ], 200);
    }


    public function topSekolahperDaerah()
    { 

     $sekolah = SchoolGsm::raw( function ( $collection ) {
        return $collection->aggregate([
            [
                '$group' => [
                    '_id'    => [ 'sekolah' => '$kabupaten_kota'],
                    'count'  => ['$sum' => 1],
                ],
                
              
            ],
            [   
              '$sort' => ['count' => -1]   
          ],
            [   
              '$limit' => 10
          ], 
        ]);
    });
      
        return response()->json([
            'message' => 'success!',
            'data'  => $sekolah
          ], 200);
    }

   

}