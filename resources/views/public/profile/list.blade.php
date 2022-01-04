@extends('layouts.public')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12 nicepink-bg white p-5">
          
            <h3>Profile Search</h3>
            <br>
            <div class="row">
                <div class="col-md-4 form-group">
                    <label>Name</label>
                    <input type="text" id="name" value="{{$query}}" class="form-control"/>
                </div>
                <div class="col-md-4 form-group">
                    <label>ID</label>
                    <input type="text" id="uid" class="form-control"/>
                </div>
                <div class="col-md-4 form-group">
                    <label>Rank</label>
                    <select id="rank" class="form-control">
                        <option value="">--Choose--</option>
                        @foreach (config('app.rank') as $key=>$opt)
                            @if($rank == $key)
                                <option selected="true" value="{{$key}}">{{$opt}}</option>
                            @else
                                <option value="{{$key}}">{{$opt}}</option>
                            @endif
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
            
                <div class="col-12 text-right">
                    <button class="btn btn-secondary" id="clear">Clear</button>&nbsp;
                    <button id="search" class="btn btn-primary">Search</button>
                </div>
            </div>
        </div>



       
    </div>
    <br>
    <div class="row" id="list"></div>
        
    <div class="row">
        <button class="btn btn-primary btn-lg btn-block" id="more">Show More</button>
       
    </div>
</div>

<script type="module">

    import {Template} from '/adarna.js';

    
    function cardsEl(item){
        
        let t = new Template();

        let card = t.div({
            class: "card mb-3",
            style: "max-width: 540px;"
        }, (el) => {
            t.div({
                class: "row g-0"
            }, (el) => {
                t.div({
                    class: "col-md-4"
                }, (el) => {
                    t.img({
                        src: "/photos/"+item.photo,
                        class: "img-fluid rounded-start",
                        alt: ""
                    }, (el) => {

                    }); //img

                }); //div
                t.div({
                    class: "col-md-8"
                }, (el) => {
                    t.div({
                        class: "card-body",
                        style:{paddingTop:'10px'}
                    }, (el) => {
                        t.h5({
                            class: "card-title"
                        }, (el) => {

                            t.txt(formatName(item));

                        }); //h5
                        t.p({
                            class: "card-text"
                        }, (el) => {

                            t.txt(item.rank);
                            t.br();
                            t.txt('📱: '+item.mobile);
                            t.br();
                            t.txt([item.region,item.province,item.city_municipality,item.barangay].join(', '));

                        }); //p
                        t.p({
                            class: "card-text"
                        }, (el) => {
                            t.small({
                                class: "text-muted"
                            }, (el) => {
                                let id = item.id+'';
                                t.txt('ID#:'+id.padStart(4,'0'));

                            }); //small

                        }); //p

                    }); //div

                }); //div

            }); //div

        }); //div

        card.onclick = (e)=>{
            document.location.href = '/profile/'+item.id;
        }
        return t.div({class:'col-md-6'},(el)=>{
            el.appendChild(card);
        });
    }

    const name      = document.querySelector('#name');
    const uid       = document.querySelector('#uid');
    const rank      = document.querySelector('#rank');
    const more      = document.querySelector('#more');
    const search    = document.querySelector('#search');
    const list      = document.querySelector('#list');
    const clear     = document.querySelector('#clear');

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

        fetch('/profiles',{
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
                alert('No results found');
                return false;
            }

            more.style.display = 'block';

            
            if(!reply.data.length){
                alert('No results found');
            }

            reply.data.map(item=>{
                let card = cardsEl(item);
                list.append(card);
            });


            location.hash = "#list";
            
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

        fetch('/profiles',{
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

      

            reply.data.map(item=>{

                let card = cardsEl(item);

                //tr.onclick = ()=>{
                  //  document.location.href = '/admin/profile/display/'+item.id
                //}
                
                list.append(card);
            });

        });
    }

    clear.onclick = ()=>{
        document.location.href = '/profiles';
    }

    areaFilter();

    if("{{$rank}}" || "{{$query}}"){
        search.click();
    }

</script>

@endsection
