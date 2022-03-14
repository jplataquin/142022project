@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Display Profile</div>

                <div class="card-body">
                    <form method="POST" action="">
                        @csrf

                        <div class="form-group row">
                            <label for="region" class="col-md-4 col-form-label text-md-right">Region</label>

                            <div class="col-md-6">
                                <input id="region" type="text" class="form-control" name="region" readonly value="{{$region}}"/>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="province" class="col-md-4 col-form-label text-md-right">Province</label>

                            <div class="col-md-6">
                                <input id="province" type="text" class="form-control" name="province" readonly value="{{$province}}"/>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="city_municipality" class="col-md-4 col-form-label text-md-right">City/Municipality</label>

                            <div class="col-md-6">
                                <input id="city_municipality" type="text" class="form-control" name="city_municipality" readonly value="{{$city_municipality}}"/>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="barangay" class="col-md-4 col-form-label text-md-right">Barangay</label>

                            <div class="col-md-6">
                                <input id="barangay" type="text" class="form-control" name="barangay" readonly value="{{$barangay}}"/>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="rank" class="col-md-4 col-form-label text-md-right">Rank</label>

                            <div class="col-md-6">
                                <input id="rank" type="text" class="form-control" name="rank" readonly value="{{$rankOptions[$rank]}}"/>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="uid" class="col-md-4 col-form-label text-md-right">UID</label>

                            <div class="col-md-6">
                                <input id="uid" type="text" class="form-control" name="uid" readonly value="{{$uid}}"/>
                            </div>
                        </div>

                        <hr>

                        <div class="form-group row">
                            <label for="photo" class="col-md-4 col-form-label text-md-right">Photo</label>

                            <div class="col-md-6">
                                <div>
                                    <img id="preview"  width="300px" height="300px"  src="{{asset('photos/'.$photo)}}" width="100%"/>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="prefix" class="col-md-4 col-form-label text-md-right">Prefix</label>

                            <div class="col-md-6">
                                <input id="prefix" type="text" class="form-control" name="prefix" readonly value="{{$prefix}}"/>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="firstname" class="col-md-4 col-form-label text-md-right">Firstname</label>

                            <div class="col-md-6">
                                <input id="firstname" type="text" class="form-control" name="firstname" readonly value="{{$firstname}}" required/>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="middlename" class="col-md-4 col-form-label text-md-right">Middlename</label>

                            <div class="col-md-6">
                                <input id="middlename" type="text" class="form-control" name="middlename" readonly value="{{$middlename}}"/>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="lastname" class="col-md-4 col-form-label text-md-right">Lastname</label>

                            <div class="col-md-6">
                                <input id="lastname" type="text" class="form-control" name="lastname" readonly value="{{$lastname}}" required/>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="suffix" class="col-md-4 col-form-label text-md-right">Suffix</label>

                            <div class="col-md-6">
                                <input id="suffix" type="text" class="form-control" name="suffix" readonly value="{{$suffix}}"/>
                            </div>
                        </div>

                        <hr>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">Email</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" readonly value="{{$email}}" required/>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="mobileno" class="col-md-4 col-form-label text-md-right">Mobile No.</label>

                            <div class="col-md-6">
                                <input id="mobile" type="text" class="form-control" name="mobile" readonly value="{{$mobile}}" required/>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="links" class="col-md-4 col-form-label text-md-right">Links</label>

                            <div class="col-md-6">
                                <input id="links" type="text" class="form-control" name="links" readonly value="{{$links}}"/>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-sm-6 text-left">     
                                <button id="cancelBtn" class="btn btn-secondary">
                                    Cancel
                                </button>
                            </div>
                            <div class="col-sm-6 text-right">
                                <button id="genBtn" class="btn btn-warning">
                                    Preview
                                </button>
                                <button id="editBtn" class="btn btn-primary">
                                    Edit
                                </button>
                            </div>
                        </div>
                    </form> 
                    
                </div>
            </div>
        </div>
    </div>
</div>

<script type="module">
    const editBtn = document.querySelector('#editBtn');
    const genBtn = document.querySelector('#genBtn');
    const cancelBtn = document.querySelector('#cancelBtn');


    editBtn.onclick = (e)=>{
        e.preventDefault();
        document.location.href = "/admin/profile/update/{{$id}}";
    }

    cancelBtn.onclick = (e)=>{
        e.preventDefault();
        document.location.href = "/admin/profile/list";
    }

    genBtn.onclick = (e)=>{
        e.preventDefault();
        window.open("/admin/profile/preview/{{$id}}"); 
    }
</script>
@endsection
