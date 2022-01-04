<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Region;
use App\Models\Province;
use App\Models\CityMunicipality;
use App\Models\Barangay;

class AreaController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //Region
            //Province
                //City Municipality
                    //Barangy
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $type       = $request->input('type');
        $constraint = $request->input('constraint');
        $value      = $request->input('value');
        
        if(!in_array($type,['reg','prov','citymun','brgy'])){
            return response()->json([
                'status'    => 0,
                'data'      => [],
                'message'   => 'Invalid type'
            ]);
        }

        $model = [
            'reg' => Region::class,
            'prov' => Province::class,
            'citymun' => CityMunicipality::class,
            'brgy' => Barangay::class
        ];

        
        if(!$constraint && !$value){
            $data = $model[$type]::all();
        }else{
            $data = $model[$type]::where($constraint,$value)->get();
        }
        
        return response()->json([
            'status'    => 1,
            'data'      => $data,
            'message'   => ''
        ]);
    }
}
