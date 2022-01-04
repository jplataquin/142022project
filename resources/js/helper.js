
function getArea(type,constraint,value){

    type = (typeof type == 'undefined') ? '' : type;
    constraint = (typeof constraint == 'undefined') ? '' : constraint;
    value = (typeof value == 'undefined') ? '' : value;

    return fetch('/api/area?' + new URLSearchParams({
        type: type,
        constraint: constraint,
        value:value
    }),{
        method: 'GET',
        headers: {
            'X-CSRF-TOKEN': 
                '{{ csrf_token() }}'
        }
    }).then(response=>response.json());

}

function areaFilter(options){
   
    options = (typeof options == 'undefined') ? {} : options;

    let optionDefault = {
        region: document.getElementById('region'),
        province: document.getElementById('province'),
        city_municipality: document.getElementById('city_municipality'),
        barangay: document.getElementById('barangay'),
        regCode: '',
        provCode:'',
        citymunCode: '',
        brgyCode:''
    };

    for(let key in optionDefault){
        options[key] = (typeof options[key] == 'undefined') ? optionDefault[key] : options[key]; 
    }


    getArea('reg').then(reply=>{
        
        if(!reply.status){
            alert(reply.message);
            return false;
        }

        options.region.innerHTML = '';

        let def = document.createElement('option');
        def.value = '';
        def.innerText = '--Choose--';

        def.selected = true;
        options.region.appendChild(def);

        reply.data.map(item=>{
            let option = document.createElement('option');

            option.value = item.regCode;
            option.innerText = item.regDesc;
            options.region.appendChild(option);
        });

        if(options.regCode != ''){
               
            options.region.value = options.regCode;
            options.region.onchange();
        }
    });

    options.region.onchange = (e)=>{

        options.city_municipality.innerHTML = '';
        options.barangay.innerHTML = '';

        getArea('prov','regCode',options.region.value).then(reply=>{
            if(!reply.status){
                alert(reply.message);
                return false;
            }

            options.province.innerHTML = '';
            options.city_municipality.innerHTML = '';
            options.barangay.innerHTML = '';
            
            let def = document.createElement('option');
            def.value = '';
            def.innerText = '--Choose--';

            def.selected = true;
            options.province.appendChild(def);

            reply.data.map(item=>{
                let option = document.createElement('option');
               
                option.value = item.provCode;
                option.innerText = item.provDesc;
                options.province.appendChild(option);
            });

            if(options.provCode != '' && options.province.querySelector('option[value="'+options.provCode+'"]')){
                options.province.value = options.provCode;
                options.province.onchange();
            }
        });
    }

    

    options.province.onchange = (e)=>{

        getArea('citymun','provCode',options.province.value).then(reply=>{
            if(!reply.status){
                alert(reply.message);
                return false;
            }

            options.city_municipality.innerHTML = '';
            options.barangay.innerHTML = '';

            let def = document.createElement('option');
            def.value = '';
            def.innerText = '--Choose--';

            def.selected = true;
            options.city_municipality.appendChild(def);

            reply.data.map(item=>{
                let option = document.createElement('option');
              
                option.value = item.citymunCode;
                option.innerText = item.citymunDesc;
                options.city_municipality.appendChild(option);
            });


            if(options.citymunCode != '' && options.city_municipality.querySelector('option[value="'+options.citymunCode+'"]')){
                options.city_municipality.value = options.citymunCode;
                options.city_municipality.onchange();
            }
        });
    }

 

    options.city_municipality.onchange = (e)=>{

        getArea('brgy','citymunCode',options.city_municipality.value).then(reply=>{
            if(!reply.status){
                alert(reply.message);
                return false;
            }

            barangay.innerHTML = '';

            let def = document.createElement('option');
            def.value = '';
            def.innerText = '--Choose--';

            def.selected = true;
            options.barangay.appendChild(def);

            reply.data.map(item=>{
                let option = document.createElement('option');
              
                option.value = item.brgyCode;
                option.innerText = item.brgyDesc;
                options.barangay.appendChild(option);

            });

            if(options.brgyCode != '' && options.barangay.querySelector('option[value="'+options.brgyCode+'"]')){
                options.barangay.value = options.brgyCode;
            }
        });
    }
}


function formatName(item){

    return item.prefix+' '+item.firstname+' '+item.middlename+' '+item.lastname+' '+item.suffix +' '.replace( /\s\s+/g, ' ' ).trim();
}