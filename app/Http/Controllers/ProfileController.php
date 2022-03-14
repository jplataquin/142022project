<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\Profile;
use App\Models\Region;
use App\Models\Province;
use App\Models\CityMunicipality;
use App\Models\Barangay;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

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

        $search = [$profile->region];
     
        if($profile->provice){
            $search[] = $profile->provice;  
        };

        if($profile->city_municipality){
            $search[] = $profile->city_municipality;  
        };

        if($profile->barangay){
            $search[] = $profile->barangay;  
        };

        $profile->search = implode(',',$search);

        $profile->rankOptions = config('app.rank');
        
        $uid = str_pad(''.$profile->id,4,'0',STR_PAD_LEFT);
        
        $uid = 'QW-'.config('app.rank_abbrev')[$profile->rank].'-'.$uid;
        
        $profile->uid = $uid;

        $address = '';

        if($profile->rank == 'ceo'){
            $address = 'Philippines';
        }if(in_array($profile->rank,['reg'])){
            $address =  $profile->region;
        }else if(in_array($profile->rank,['pro','pro2','pro3'])){
            $address = $profile->province;
        }else if(in_array($profile->rank,['dis','dis2','dis3','dis4','dis5','dis6','dis7','dis8'])){

            switch($profile->rank){

                case 'dis':
                    $address = '1st District, '.$profile->province;
                    break;
                case 'dis2':
                    $address = '2nd District, '.$profile->province;
                    break;
                case 'dis3':
                    $address = '3rd District, '.$profile->province;
                    break;
                case 'dis4':
                    $address = '4th District, '.$profile->province;
                    break;
                case 'dis5':
                    $address = '5th District, '.$profile->province;
                    break;
                case 'dis6':
                    $address = '6th District, '.$profile->province;
                    break;
                case 'dis7':
                    $address = '7th District, '.$profile->province;
                    break;
                case 'dis8':
                    $address = 'th District, '.$profile->province;
                    break;
            }
            
        }else if(in_array($profile->rank,['cit','cit2','cit3'])){
            
            $address = $profile->city_municipality;
            
        }else if(in_array($profile->rank,['res','sub'])){
            $address = implode(',',[$profile->brgy,$profile->city_municipality,$profile->province]); 
        }

        $profile->address = $address;

        return view('public/profile/display',$profile);
    }

    public function list(Request $request){
     
        $query = $request->input('q');
        $rank  = $request->input('r');

        return view('public/profile/list',[
            'query' => $query,
            'rank'  => $rank
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

        $skip   = $page * 6;
        $result = $profile->skip($skip)->take(6)->get();


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
