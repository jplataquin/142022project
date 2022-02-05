<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\Profile;
use App\Models\Region;
use App\Models\Province;
use App\Models\CityMunicipality;
use App\Models\Barangay;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


class ProfileController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }


    /**
     * Show the create form.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create()
    {
        return view('admin/profile/create');
    }

    public function POST_create(Request $request){

        $validated = $validator = Validator::make($request->all(),[
            'rank'              => ['required',Rule::in(array_keys(config('app.rank'))),'max:255'],
            'region'            => 'required|max:255',
            'province'          => 'max:255',
            'city_municipality' => 'max:255',
            'barangay'          => 'max:255',
            'firstname'         => 'required|max:255',
            'lastname'          => 'required|max:255',
            'email'             => 'required|email|max:255',
            'mobile'            => 'required|max:255',
            'links'             => 'max:255',
            'photo'             => 'required|image|mimes:jpg|dimensions:min_width=300,min_height=300'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 0,
                'data' =>  $validator->errors(),
                'message' => 'Validation errors'
            ]);
        }

        try{
            
            $path = $request->file('photo')->store('photos');

        }catch(Exception $e){

            return  response()->json([
                'status'    => 0,
                'data'      => [],
                'message'   => 'Unable to upload file'
            ]);
        }
        
        $photo = str_replace('photos/','',$path);

        $profile = new Profile();

        $profile->rank              = $request->input('rank');
        $profile->region            = $request->input('region');
        $profile->province          = $request->input('province');
        $profile->city_municipality = $request->input('city_municipality');
        $profile->barangay          = $request->input('barangay');
        $profile->prefix            = $request->input('prefix') ?? '';
        $profile->firstname         = $request->input('firstname');
        $profile->middlename        = $request->input('middlename') ?? '';
        $profile->lastname          = $request->input('lastname');
        $profile->suffix            = $request->input('suffix') ?? '';
        $profile->email             = $request->input('email') ?? '';
        $profile->mobile            = $request->input('mobile') ?? '';
        $profile->links             = $request->input('links') ?? '';
        $profile->photo             = $photo;
        
        $test = $profile->save();
        
        if(!$test){
            
            Storage::disk('photos')->delete($photo);

            return response()->json([
                'status'    => 0,
                'data'      => [],
                'message'   => 'Create record failed'
            ]);
        }
              
        
        return response()->json([
            'status'    => 1,
            'data'      => [
                'id' => $profile->id
            ],
            'message'   => ''
        ]);
    }

    public function display($id){

        $profile = Profile::find($id);;
        
        if(!$profile){
            return abort(404);
        }

        $region             = Region::where('regCode',$profile->region)->first() ?? '';
        $province           = Province::where('provCode',$profile->province)->first() ?? '';
        $city_municipality  = CityMunicipality::where('citymunCode',$profile->city_municipality)->first() ?? '';
        $barangay           = Barangay::where('brgyCode',$profile->barangay)->first() ?? '';
        
        $profile->region            = $region->regDesc ?? '';
        $profile->province          = $province->provDesc ?? '';
        $profile->city_municipality = $city_municipality->citymunDesc ?? '';
        $profile->barangay          = $barangay->brgyDesc ?? '';

        $profile->rankOptions = config('app.rank');
        
        return view('admin/profile/display',$profile);
    }

    public function preview($id){

        $profile = Profile::find($id);;
        
        if(!$profile){
            return abort(404);
        }

        $region             = Region::where('regCode',$profile->region)->first() ?? '';
        $province           = Province::where('provCode',$profile->province)->first() ?? '';
        $city_municipality  = CityMunicipality::where('citymunCode',$profile->city_municipality)->first() ?? '';
        $barangay           = Barangay::where('brgyCode',$profile->barangay)->first() ?? '';
        
        $profile->region            = $region->regDesc;
        $profile->province          = $province->provDesc ?? '';
        $profile->city_municipality = $city_municipality->citymunDesc ?? '';
        $profile->barangay          = $barangay->brgyDesc ?? '';

        return view('admin/profile/preview',$profile);
    }

    public function update($id){

        $profile = Profile::findOrFail($id);;
        
        if(!$profile){
            return abort(404);
        }
        
        $profile->rankOptions = config('app.rank');
        
        return view('admin/profile/update',$profile);
    }

    public function POST_update($id,Request $request){
        
        $profile = Profile::find($id);;
        
        if(!$profile){
            return response()->json([
                'status'    => 0,
                'data'      => [],
                'message'   => 'Record not found'
            ]);
        }
        
        if($request->file('photo')){
           
            $imgData = getimagesize($request->file('photo'));

           // return 'image|mimes:jpg|max:2048|dimensions:min_width='.$imgData[0].',min_height='.$imgData[0].',max_width=500,max_height='.$imgData[0];

            $validated = $validator = Validator::make($request->all(),[
                'rank'              => ['required',Rule::in(array_keys(config('app.rank'))),'max:255'],
                'region'            => 'required|max:255',
                'province'          => 'max:255',
                'city_municipality' => 'max:255',
                'barangay'          => 'max:255',
                'firstname'         => 'required|max:255',
                'lastname'          => 'required|max:255',
                'email'             => 'required|email|max:255',
                'mobile'            => 'required|max:255',
                'links'             => 'max:255',
                'photo'             => 'image|mimes:jpg|max:2048|dimensions:min_width='.$imgData[0].',min_height='.$imgData[0].',max_width='.$imgData[0].',max_height='.$imgData[0]
            ]);
        
        }else{

            $validated = $validator = Validator::make($request->all(),[
                'rank'              => ['required',Rule::in(array_keys(config('app.rank'))),'max:255'],
                'region'            => 'required|max:255',
                'province'          => 'max:255',
                'city_municipality' => 'max:255',
                'barangay'          => 'max:255',
                'firstname'         => 'required|max:255',
                'lastname'          => 'required|max:255',
                'email'             => 'required|email|max:255',
                'mobile'            => 'required|max:255',
                'links'             => 'max:255',
            ]);
        }
      

        if ($validator->fails()) {
            return response()->json([
                'status' => 0,
                'data' =>  $validator->errors(),
                'message' => 'Validation errors'
            ]);
        }


        
        $profile->rank              = $request->input('rank');
        $profile->region            = $request->input('region');
        $profile->province          = $request->input('province');
        $profile->city_municipality = $request->input('city_municipality');
        $profile->barangay          = $request->input('barangay');
        $profile->prefix            = $request->input('prefix') ?? '';
        $profile->firstname         = $request->input('firstname');
        $profile->middlename        = $request->input('middlename') ?? '';
        $profile->lastname          = $request->input('lastname');
        $profile->suffix            = $request->input('suffix') ?? '';
        $profile->email             = $request->input('email') ?? '';
        $profile->mobile            = $request->input('mobile') ?? '';
        $profile->links             = $request->input('links') ?? '';

        if($request->file('photo')){
            
            try{
                
               $path = $request->file('photo')->store('photos');

            }catch(Exception $e){

                return  response()->json([
                    'status'    => 0,
                    'data'      => [],
                    'message'   => 'Unable to upload file'
                ]);
            }
        
            $photo = str_replace('photos/','',$path);

            Storage::disk('local')->delete('photos/'.$profile->photo);

            
            $profile->photo  = $photo;
        }

        
        $test = $profile->save();
        
        if(!$test){
            
            Storage::disk('local')->delete('photos/'.$photo);

            return response()->json([
                'status'    => 0,
                'data'      => [],
                'message'   => 'Create record failed'
            ]);
        }
              
        return response()->json([
            'status'    => 1,
            'data'      => [
                'id' => $profile->id
            ],
            'message'   => ''
        ]);
    }


    public function list(){
     
        return view('admin/profile/list');
    }

    public function POST_remove(Request $request){
        
        $id = (int) $request->input('id');
        $profile = Profile::find($id);
        
        if(!$profile){
            return response()->json([
                'status'    => 0,
                'data'      => [],
                'message'   => 'Record not found'
            ]);
        }
        
        Storage::disk('local')->delete('photos/'.$profile->photo);

        $profile->forceDelete();

        return response()->json([
            'status'    => 1,
            'data'      => [],
            'message'   => ''
        ]);
    }

    public function POST_list(Request $request){

        $name               = $request->input('name');
        $uid                = $request->input('uid');
        $rank               = $request->input('rank');
        $regCode            = $request->input('regCode');
        $provCode           = $request->input('provCode');
        $citymunCode        = $request->input('citymunCode');
        $brgyCode           = $request->input('brgyCode');
        $page               = $request->input('page');

        $profile = new Profile();
       
        if($name){
            $profile = $profile->orWhere('prefix' , 'LIKE' , '%'.$name.'%');
            $profile = $profile->orWhere('firstname' , 'LIKE' , '%'.$name.'%');
            $profile = $profile->orWhere('middlename' , 'LIKE' , '%'.$name.'%');
            $profile = $profile->orWhere('lastname' , 'LIKE' , '%'.$name.'%');
            $profile = $profile->orWhere('suffix' , 'LIKE' , '%'.$name.'%');
        }

        if($uid){
            $profile = $profile->where('id',$uid);
        }

        if($rank){
            $profile = $profile->where('rank',$rank);
        }

        if($regCode){
            $profile = $profile->where('region',$regCode);  
        }

        if($provCode){
            $profile = $profile->where('province',$provCode);
        }

        if($citymunCode){
            $profile = $profile->where('city_municipality',$citymunCode);
        }

        if($brgyCode){
            $profile = $profile->where('barangay',$brgyCode);
        }

        $skip   = $page * 5;
        $result = $profile->skip($skip)->take(5)->get();


        $data = [];

        $rankOptions = config('app.rank');
        
        foreach($result as $item){

            $item->prefix               = $item->prefix ?? '';
            $item->firstname            = $item->firstname ?? '';
            $item->middlename           = $item->middlename ?? '';
            $item->lastname             = $item->lastname ?? '';
            $item->suffix               = $item->suffix ?? '';
            $item->region               = Region::where('regCode',$item->region)->first()->regDesc ?? '';
            $item->province             = Province::where('provCode',$item->province)->first()->provDesc ?? '';
            $item->city_municipality    = CityMunicipality::where('citymunCode',$item->city_municipality)->first()->citymunDesc ?? '';
            $item->barangay             = Barangay::where('brgyCode',$item->barangay)->first()->brgyDesc ?? '';
            $item->rank                 = $rankOptions[$item->rank] ?? '';
            $data[] = $item;
        }

        return response()->json([
            'status'    => 1,
            'data'      => $data,
            'message'   => ''
        ]);
    }
}
