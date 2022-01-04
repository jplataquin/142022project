@extends('layouts.public')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Display Profile</div>

                <div class="card-body" style="background-image:url({{asset('img/bg.png')}}); background-size: 100%;">
                    

                        <div class="row">

                            <div class="col-md-12">
                                <div class="text-center">
                                    <img  class="rounded-circle border-10px hotpink pic"  src="{{asset('photos/'.$photo)}}" width="100%"/>
                                </div>
                                
                                <div>
                                    <img class="float-left rounded-circle border-5px hotpink"  width="100px" height="100px"  src="{{asset('img/logo.png')}}" width="100%"/>
                                    <div class="nicepink-bg white name">{{$prefix}} {{$firstname}} {{$middlename}} {{$lastname}} {{$suffix}}</div>
                                </div>
                               
                                <div class="{{$rank}}-bg white rounded-right rank">{{config('app.rank')[$rank]}}</div>
                            </div>
                        </div>
                        <br>
                      <div class="row">
                         
                        <div class="col-lg-6 field-row">
                           <div class="hotpink-bg white label-icon">
                                    <i class="bi bi-geo-alt-fill"></i>
                            </div>
                            <div class="field">
                               {{join(', ',[$region,$province,$city_municipality,$barangay])}}
                            </div>
                        </div>
                        <div class="col-lg-6 field-row">
                           <div class="hotpink-bg white label-icon">
                                    <i class="bi bi-facebook"></i>
                            </div>
                            <div class="field">
                                <a target="__blank" href="https://facebook.com/{{$links}}">{{$links}}</a>
                            </div>
                        </div>
                        <div class="col-lg-6 field-row">
                           <div class="hotpink-bg white label-icon">
                                    <i class="bi bi-telephone-fill"></i>
                            </div>
                            <div class="field">
                                {{$mobile}}
                            </div>
                        </div>
                        <div class="col-lg-6 field-row">
                           <div class="hotpink-bg white label-icon">
                                    <i class="bi bi-person-fill"></i>
                            </div>
                            <div class="field">
                                {{str_pad($id,4,0,STR_PAD_LEFT)}}
                            </div>
                        </div>
                      </div>

                

                     
                    <div class="row">
                        
                        <div class="col-sm-12 text-right">
                            
                            <button id="back" class="btn btn-secondary">
                                Back
                            </button>
                        </div>
                    </div>
                    
                    
                </div>
            </div>
        </div>
    </div>
</div>

<script type="module">
    const back = document.querySelector('#back');



    back.onclick = (e)=>{
        e.preventDefault();
        document.location.href = "/profiles";
    }

</script>
@endsection
