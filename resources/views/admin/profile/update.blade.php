@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Update Profile</div>

                <div class="card-body">
                    <form method="POST" action="">
                        @csrf

                        <div class="form-group row">
                            <label for="region" class="col-md-4 col-form-label text-md-right">Region</label>

                            <div class="col-md-6">
                                <select id="region" class="form-control"></select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="province" class="col-md-4 col-form-label text-md-right">Province</label>

                            <div class="col-md-6">
                                <select id="province" class="form-control"></select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="city_province" class="col-md-4 col-form-label text-md-right">City/Municipality</label>

                            <div class="col-md-6">
                                <select id="city_municipality" class="form-control"></select>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="location" class="col-md-4 col-form-label text-md-right">Barangay</label>

                            <div class="col-md-6">
                                <select id="barangay" class="form-control"></select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="rank" class="col-md-4 col-form-label text-md-right">Rank</label>

                            <div class="col-md-6">
                                <select id="rank" class="form-control">
                                    @foreach ($rankOptions as $key=>$opt)
                                        @if ($key == $rank)
                                            <option selected="true" value="{{$key}}">{{$opt}}</option>
                                        @else
                                            <option value="{{$key}}">{{$opt}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="uid" class="col-md-4 col-form-label text-md-right">UID</label>

                            <div class="col-md-6">
                                <input id="uid" readonly="true" type="text" class="form-control" name="uid" value="{{str_pad($id,4,0,STR_PAD_LEFT)}}"/>
                            </div>
                        </div>

                        <hr>

                        <div class="form-group row">
                            <label for="photo" class="col-md-4 col-form-label text-md-right">Photo</label>

                            <div class="col-md-6">

                                <img id="finalphoto" width="300px" height="300px" src="{{asset('photos/'.$photo)}}"/>
                                <div>
                                    <img id="preview" src="" width="100%"/>
                                </div>
                                <input id="photo" type="file" class="form-control" name="photo" value=""/>
                                <div class="text-right">
                                    <button class="btn btn-primary" id="crop">Crop</button>
                                </div>
                          
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="prefix" class="col-md-4 col-form-label text-md-right">Prefix</label>

                            <div class="col-md-6">
                                <input id="prefix" type="text" class="form-control" name="prefix" value="{{$prefix}}"/>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="firstname" class="col-md-4 col-form-label text-md-right">Firstname</label>

                            <div class="col-md-6">
                                <input id="firstname" type="text" class="form-control" name="firstname" value="{{$firstname}}" required/>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="middlename" class="col-md-4 col-form-label text-md-right">Middlename</label>

                            <div class="col-md-6">
                                <input id="middlename" type="text" class="form-control" name="middlename" value="{{$middlename}}"/>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="lastname" class="col-md-4 col-form-label text-md-right">Lastname</label>

                            <div class="col-md-6">
                                <input id="lastname" type="text" class="form-control" name="lastname" value="{{$lastname}}" required/>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="suffix" class="col-md-4 col-form-label text-md-right">Suffix</label>

                            <div class="col-md-6">
                                <input id="suffix" type="text" class="form-control" name="suffix" value="{{$suffix}}"/>
                            </div>
                        </div>

                        <hr>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">Email</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{$email}}" required/>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="mobileno" class="col-md-4 col-form-label text-md-right">Mobile No.</label>

                            <div class="col-md-6">
                                <input id="mobile" type="text" class="form-control" name="mobile" value="{{$mobile}}" required/>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="links" class="col-md-4 col-form-label text-md-right">Links</label>

                            <div class="col-md-6">
                                <input id="links" type="text" class="form-control" name="links" value="{{$links}}"/>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-sm-6 text-left">
                                <button id="cancel" class="btn btn-secondary">
                                    Cancel
                                </button>
                            </div>
                            <div class="col-sm-6 text-right">
                                <button id="submit" class="btn btn-primary">
                                    Update
                                </button>
                            </div>
                        </div>
                    </form> 
                    <link href="/cropperjs/cropper.min.css" rel="stylesheet">
                    <style>
                        img {
                            display: block;

                            /* This rule is very important, please don't ignore this */
                            max-width: 100%;
                        }
                    </style>
                    <script type="module">
                        
                        import '/cropperjs/cropper.min.js';
                        
                        let ids = [
                            'region',
                            'province',
                            'city_municipality',
                            'barangay',
                            'rank',
                            'prefix',
                            'firstname',
                            'middlename',
                            'lastname',
                            'suffix',
                            'email',
                            'mobile',
                            'links'
                        ];

                        const submit        = document.querySelector('#submit');
                        const photo         = document.querySelector('#photo');
                        const preview       = document.querySelector('#preview');
                        const cropBtn       = document.querySelector('#crop');
                        const finalphoto    = document.querySelector('#finalphoto');
                        const cancel        = document.querySelector('#cancel');

                        let cropper;

                        //hide preview, finalphoto, and cropBtn
                        preview.style.display = 'none';
                        cropBtn.style.display = 'none';
                        
                  
                        preview.onload = ()=>{

                            finalphoto.src = '';
                            finalphoto.style.display = 'none';

                            if(typeof cropper != 'undefined'){
                                cropper.destroy();
                            }

      
                            cropper = new Cropper(preview, {
                                rotatable:false,
                                aspectRatio: 1 / 1,
                                autoCropArea:1
                            });

                            console.log("loaded");
                        }


                        cropBtn.onclick = (e)=>{
                            e.preventDefault();
                            
                            finalphoto.src = '';
                            finalphoto.style.display = 'none';

                            if(typeof cropper == 'undefined'){
                                return false;
                            }

                            cropper.getCroppedCanvas().toBlob((blob) => {
                                
                                finalphoto.src = URL.createObjectURL(blob);

                                cropper.destroy();
                                preview.src = '';

                                preview.style.display = 'none';
                                cropBtn.style.display = 'none';
                                finalphoto.style.display = 'inline';

                            });
                        }

                        cancel.onclick = (e)=>{
                            e.preventDefault();
                            document.location.href = '/admin/profile/display/{{$id}}';
                        }

                        photo.onchange = (e)=>{
                            const [file] = photo.files;
                            if (file) {
                                
                                preview.src = URL.createObjectURL(file);
                                preview.style.display = 'inline';
                                cropBtn.style.display = 'inline';
                            }
                        }

                        function getData(ids){

                            let data = {};

                            ids.map(id=>{
                                data[id] = document.getElementById(id).value;
                            });

                            return data;
                        }

                        
                        function convertImageToBlob(img){

                            return new Promise((resolve,reject)=>{

                                if(img.src == ''){

                                    return reject('No data');
                                }

                                let c = document.createElement('canvas');
                                
                                c.width = img.naturalWidth; 
                                c.height = img.naturalHeight;
                                let ctx = c.getContext('2d');
                                ctx.drawImage(img, 0, 0); 
                                
                                try{
                                    c.toBlob(function(blob) {
                                        resolve(blob);
                                    }, 'image/jpeg', 1);
                                }catch(e){
                                    reject(e);
                                }
                               
                            });
                            
                        }

                        submit.onclick = async (e)=>{
                            e.preventDefault();

                            Array.from(document.querySelectorAll('.is-invalid')).map(item=>{
                                item.classList.remove('is-invalid');
                            });

                            let blob = await convertImageToBlob(finalphoto);

                            if(!blob){
                                alert('Photo is required');
                                return false;
                            }
                            
                            let form = new FormData();
                           
                            
                            ids.map(id=>{
                                form.append(id,document.getElementById(id).value);
                            });

                            form.append('photo',blob);

                            fetch('',{
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': 
                                        '{{ csrf_token() }}'
                                },
                                body: form
                            }).then(response => response.json())
                            .then((reply)=>{
                              
                                if(!reply.status){

                                    for(let key in reply.data){
                                        let item = document.querySelector('#'+key);
                                        item.classList.add('is-invalid');
                                    }

                                    alert(reply.message);
                                    return false;
                                }
                                
                                document.location.href = '/admin/profile/display/'+reply.data.id;
                            });
                        }
                            
                    
                        areaFilter({
                            regCode :"{{$region}}",
                            provCode:"{{$province}}",
                            citymunCode:"{{$city_municipality}}",
                            brgyCode:"{{$barangay}}"
                        });
                    </script>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
