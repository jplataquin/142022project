@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h3>Profile List</h3>

            <div class="row">
                <div class="col-md-4 form-group">
                    <label>Name</label>
                    <input type="text" id="name" class="form-control"/>
                </div>
                <div class="col-md-4 form-group">
                    <label>UID</label>
                    <input type="text" id="uid" class="form-control"/>
                </div>
                <div class="col-md-4 form-group">
                    <label>Rank</label>
                    <select id="rank" class="form-control">
                        <option value="">--Choose--</option>
                        @foreach (config('app.rank') as $key=>$opt)
                            <option value="{{$key}}">{{$opt}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 form-group">
                    <label>Region</label>
                    <select id="region" class="form-control"></select>
                </div>
                <div class="col-md-3 form-group">
                    <label>Province</label>
                    <select id="province" class="form-control"></select>
                </div>
                <div class="col-md-3 form-group">
                    <label>City / Municipality</label>
                    <select id="city_municipality" class="form-control"></select>
                </div>
                <div class="col-md-3 form-group">
                    <label>Barangay</label>
                    <select id="barangay" class="form-control"></select>
                </div>
            </div>
            <div class="row">
                
                <div class="col-6 text-left">
                    <button class="btn btn-warning" id="create">Create</button>
                </div>
                <div class="col-6 text-right">
                    <button id="search" class="btn btn-primary">Search</button>
                </div>
            </div>
        </div>



       
    </div>

    <div class="row div-table-container">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">UID</th>
                    <th scope="col">Rank</th>
                    <th scope="col">Name</th>
                    <th scope="col">Region</th>
                    <th scope="col">Province</th>
                    <th scope="col">City / Municipality</th>
                    <th scope="col">Barangay</th>
                </tr>
            </thead>
            <tbody id="list">

            </tbody>
        </table>  
    </div>
        
    <div class="row">
        <button class="btn btn-primary btn-lg btn-block" id="more">Show More</button>
       
    </div>
</div>

<script type="module">

    import {Template} from '/adarna.js';

    const name      = document.querySelector('#name');
    const uid       = document.querySelector('#uid');
    const rank      = document.querySelector('#rank');
    const more      = document.querySelector('#more');
    const search    = document.querySelector('#search');
    const list      = document.querySelector('#list');
    const create    = document.querySelector('#create');

    let page = 0;

    more.style.display = 'none';

    search.onclick = (e)=>{
        list.innerHTML = '';
        page     = 0;
        let form = new FormData();

        form.append('name',name.value);
        form.append('uid',uid.value);
        form.append('rank',rank.value);
        form.append('regCode',region.value);
        form.append('provCode',province.value);
        form.append('citymunCode',city_municipality.value);
        form.append('brgyCode',barangay.value);
        form.append('page',page);

        fetch('/admin/profile/list',{
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': 
                    '{{ csrf_token() }}'
            },
            body: form
        }).then(response=>response.json())
        .then((reply)=>{

            if(!reply.status){
                alert(reply.message);
                return false;
            }

            if(!reply.data.length){
                more.style.display = 'none';
                return false;
            }

            more.style.display = 'block';

            const t = new Template();

            reply.data.map(item=>{
        
                let tr = t.tr({class:'clickable'},()=>{
                    t.td(''+item.id);
                    t.td(item.rank);
                    t.td(formatName(item));
                    t.td(item.region);
                    t.td(item.province);
                    t.td(item.city_municipality);
                    t.td(item.barangay);
                });

                tr.onclick = ()=>{
                    document.location.href = '/admin/profile/display/'+item.id
                }

                list.append(tr);
            });
            
        });
    }


    more.onclick = ()=>{

        page++;

        let form = new FormData();

        form.append('name',name.value);
        form.append('uid',uid.value);
        form.append('rank',rank.value);
        form.append('regCode',region.value);
        form.append('provCode',province.value);
        form.append('citymunCode',city_municipality.value);
        form.append('brgyCode',barangay.value);
        form.append('page',page);

        fetch('/admin/profile/list',{
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': 
                    '{{ csrf_token() }}'
            },
            body: form
        }).then(response=>response.json())
        .then((reply)=>{

            if(!reply.status){
                alert(reply.message);
                return false;
            }

            if(!reply.data.length){
                more.style.display = 'none';
                return false;
            }

            const t = new Template();

            reply.data.map(item=>{

                let tr = t.tr(()=>{
                    t.td(''+item.id);
                    t.td(item.rank);
                    t.td(formatName(item));
                    t.td(item.region);
                    t.td(item.province);
                    t.td(item.city_municipality);
                    t.td(item.barangay);
                });

                tr.onclick = ()=>{
                    document.location.href = '/admin/profile/display/'+item.id
                }
                
                list.append(tr);
            });

        });
    }

    create.onclick = (e)=>{
        e.preventDefault();
        document.location.href = '/admin/profile/create';
    }

    areaFilter();

</script>

@endsection
