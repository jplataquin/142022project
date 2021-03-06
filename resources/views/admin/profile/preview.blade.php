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
                width:300px;
                display: block;
                margin: auto;
                position: relative;
                top:115px;
            }
        }


        #circle{
            position:relative;
            top: 68px;
            z-index: 0;
        }

        #name-div{
            position: relative;
            z-index: 10;
        }

        #rank{
            width:60%;
            margin-left:100px;
            padding-left: 30px;
            font-size:17px;
        }

        #logo{
            width:150px;
            height:150px;
            position:relative;
            top:-20px;
        }

        #name{
            border-bottom-right-radius: 25px;
            border-top-left-radius: 50px;
            min-height:50px;
            padding-top:10px;
            padding-bottom:10px;
        }

        #mobile{
            font-size: 20px;
            padding:5px !important;
        }

        #content-position{
            margin-top:-140px;
        }
    </style>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8" style="padding:0px !important;">
                <div class="card" style="min-width:728px;max-width:728px;min-height:728px;max-height:728px;width:728px;height:728px">

                    <div  class="card-body" style="background-image:url({{asset('img/bg.png')}}); background-size: 100%;">
                        

                            <div class="row">

                                <div class="col-md-12" id="content-position">
                                    <div class="text-center">
                                        <img id="crown" src="{{url('/crown.png')}}"/>
                                        <img  id="circle" class="rounded-circle border-10px hotpink"  src="{{asset('photos/'.$photo)}}" width="400px"/>
                                    </div>
                                    
                                    <div class="">
                                        <div id="name-div" class="name-div">
                                            <img id="logo" class="float-left rounded-circle border-5px hotpink"  src="{{asset('img/logo.png')}}"/>
                                            <div id="name" class="nicepink-bg white usnr">{{$prefix}} {{$firstname}} {{$middlename}} {{$lastname}} {{$suffix}}</div>
                                        </div>
                                    </div>
                                
                                    <div id="rank" class="{{$rank}}-bg white rounded-right gotham text-center">{{config('app.rank')[$rank]}}</div>
                                </div>
                            </div>
                            <br>
                        <div class="row">
                            
                            <div class="col-lg-6 field-row">
                            <div class="hotpink-bg white label-icon">
                                        <i class="bi bi-geo-alt-fill"></i>
                                </div>
                                <div class="field text-center">
                                    {{$address}}
                                </div>
                            </div>
                            <div class="col-lg-6 field-row">
                            <div class="hotpink-bg white label-icon">
                                        <i class="bi bi-facebook"></i>
                                </div>
                                <div class="field hotpink text-center">
                                   {{$links}}
                                </div>
                            </div>
                            <div class="col-lg-6 field-row">
                            <div class="hotpink-bg white label-icon">
                                        <i class="bi bi-telephone-fill"></i>
                                </div>
                                <div id="mobile" class="field text-center">
                                    {{$mobile}}
                                </div>
                            </div>
                            <div class="col-lg-6 field-row">
                            <div class="hotpink-bg white label-icon">
                                        <i class="bi bi-person-fill"></i>
                                </div>
                                <div class="field text-center">
                                    {{$uid}}
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
        
         document.write('<img src="'+canvas.toDataURL('image/jpeg', 1.0)+'" width="700px"/>');
        //document.write('<img src="'+canvas.toDataURL('image/jpeg', 1.0)+'" width="700px/>');
        /** 
        let iframe = "<iframe style='border:0px' width='100%' height='100%' src='" + canvas.toDataURL('image/jpeg', 1.0) + "'></iframe>"
        //var x = window.open();
        //x.document.open();
        document.write(iframe);
        //x.document.close();

        **/
       
    });


    </script>
</body>
</html>
