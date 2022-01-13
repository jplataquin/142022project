@extends('layouts.public')

@section('content')

<style>
    @font-face {
        font-family: gotham;
        src: url(/GothamBold.ttf);
    }

    @font-face {
        font-family: usnr;
        src: url(/usnr.ttf);
    }

    @media (min-width:320px)  { 

        #crown{
            width:150px;
            display: block;
            margin: auto;
            position: relative;
            top:25px;
        }
    }

    @media (min-width:600px)  { 
        .usnr{
            font-family: usnr;
            font-size: 30px;
        }

        .gotham{
            font-family: gotham;
        }

        .field{
            font-family: gotham;
        }

        .name-div{
            width:80%;
            margin:auto;
        }

        #crown{
            width:150px;
            display: block;
            margin: auto;
            position: relative;
            top:25px;
        }
    }
</style>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Display Profile</div>

                <div class="card-body" style="background-image:url({{asset('img/bg.png')}}); background-size: 100%;">
                    

                        <div class="row">

                            <div class="col-md-12">
                                <div class="text-center">
                                    <img id="crown" src="{{url('/crown.png')}}"/>
                                    <img  class="rounded-circle border-10px hotpink pic"  src="{{asset('photos/'.$photo)}}" width="100%"/>
                                </div>
                                
                                <div class="">
                                    <div class="name-div">
                                        <img class="float-left rounded-circle border-5px hotpink"  width="100px" height="100px"  src="{{asset('img/logo.png')}}" width="100%"/>
                                        <div class="nicepink-bg white name usnr">{{$prefix}} {{$firstname}} {{$middlename}} {{$lastname}} {{$suffix}}</div>
                                    </div>
                                </div>
                               
                                <div class="{{$rank}}-bg white rounded-right rank gotham">{{config('app.rank')[$rank]}}</div>
                            </div>
                        </div>
                        <br>
                      <div class="row">
                         
                        <div class="col-lg-6 field-row">
                           <div class="hotpink-bg white label-icon">
                                    <i class="bi bi-geo-alt-fill"></i>
                            </div>
                            <div class="field">
                               <a target="_blank" href="https://www.google.com/maps/search/?api=1&query={{urlencode('Philippines,'.$search)}}">{{join(', ',[$region,$province,$city_municipality,$barangay])}}</a>
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
