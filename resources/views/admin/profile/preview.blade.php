<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Queen White</title>

        <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
        <link rel="manifest" href="/site.webmanifest">
        <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
        <meta name="msapplication-TileColor" content="#da532c">
        <meta name="theme-color" content="#ffffff">



        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>

        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">


        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/theme.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.1/font/bootstrap-icons.css">
        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
        </style>
        <script type="text/javascript" src="{{ asset('js/helper.js') }}"></script>
        <script type="text/javascript" src="{{url('js/html2canvas.min.js')}}"></script>
    </head>
    <body>

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
                                {{join(', ',[$region,$province,$city_municipality,$barangay])}}
                                </div>
                            </div>
                            <div class="col-lg-6 field-row">
                            <div class="hotpink-bg white label-icon">
                                        <i class="bi bi-facebook"></i>
                                </div>
                                <div class="field hotpink">
                                   {{$links}}
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

                    

             
                        
                    </div>
                </div>
            </div>
        </div>
    </div>

   
    <script>
        
    html2canvas(document.querySelector(".card")).then(canvas => {
        document.location.href = canvas.toDataURL();
       
    });


    </script>
</body>
</html>
