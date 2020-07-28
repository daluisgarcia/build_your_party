
function removeAllChilds(element) {
    let child = element.lastChild;
    while(child){
        element.removeChild(child);
        child = element.lastChild;
    }
}

function initMap(){
    var location = {lat: latitud, lng: longitud};
    map = new google.maps.Map(document.getElementById('map'), {
        zoom: zoomNum,
        center: location
    });
}

function makeMarker(location) {
    return new google.maps.Marker({
        position: location,
        map: map
    })
}

var latitud = 7.475430;
var longitud = -64.211732;
var zoomNum = 6;
var map;

//TOGGLE DEL SELECT DE RELIGION
var option = document.getElementsByClassName('option');
for (let i = 0; i < option.length; i++) {
    option[i].addEventListener('click', function (event) {

        let op = event.target.value;

        if((op === 'jefatura') || (op === 'notaria')){
            document.getElementById('religion-select').classList.add('d-none');
            document.getElementById('religion-label').classList.add('d-none');
        }else if(op === 'templo'){
            document.getElementById('religion-select').classList.remove('d-none');
            document.getElementById('religion-label').classList.remove('d-none');
        }else{
            //HACER ALGO?
        }
    });
}

//USO DE AJAX AL ESTABLECER LOS PARAMETROS DE BUSQUEDA
document.getElementById('search-btn').addEventListener('click', function (event) {

    event.preventDefault() //IMPIDE QUE SE ENVIE EN FORMULARIO AUTOMATICAMENTE

    //DEVUELVE EL VALOR DE LA OPCION QUE ESTE SELECIONADA
    let op = document.querySelector('input[name="op-select"]:checked').value;

    //DEVUELVE EL VALOR DEL ID DE LA PARROQUIA SELECIONADA
    let city = document.getElementById('parroquia-select');
    let index = city.selectedIndex;
    city = city[index].value;

    let peticion = new XMLHttpRequest()
    let params = '';

    if(op === 'templo'){
        let religion = document.getElementById('religion-select');
        index = religion.selectedIndex;
        religion = religion[index].value;
        params = `option=${op}&religion=${religion}&cityid=${city}`   //PARTE DE LA URL QUE DEFINE LOS ELEMENTOS DE GET
    }else{
        params = `option=${op}&cityid=${city}`   //PARTE DE LA URL QUE DEFINE LOS ELEMENTOS DE GET
    }
    peticion.open('GET', `./getSites.php?${params}`)

    peticion.send()

    //loader.classList.add('active');

    peticion.onreadystatechange = function () {
        if (peticion.readyState == 4 && peticion.status == 200) {
            //loader.classList.remove('active')
        }
    }

    peticion.onload = function () {
        let data = JSON.parse(peticion.responseText);
        console.log(data)
        let container = document.getElementById('site-info');
        removeAllChilds(container);
        if(data.error){
            let element = document.createElement('p')
            element.innerText = data.error
            document.getElementById('site-info').appendChild(element)
        }else{
            if (data.length > 0) {
                latitud = parseFloat(data[0].latitud);
                longitud = parseFloat(data[0].longitud);
                zoomNum = 15;
                //Se incia el mapa con los nuevos datos
                initMap();
                //Se coloca el marcador en el mapa
                makeMarker({lat: latitud, lng: longitud});
                //Estructura del HTML
                let row = document.createElement('div');
                row.classList.add('container-fluid');
                let name = document.createElement('div');
                name.classList.add("h2", "mx-auto", "my-3");
                name.innerText = data[0].nombre;
                let dat = document.createElement('div');
                dat.classList.add("mx-auto", "mb-3");
                dat.innerHTML = '<b>Responsable</b>: '+data[0].persona;
                row.appendChild(name);
                row.appendChild(dat);
                let btnContainer = document.createElement('div');
                btnContainer.classList.add('row');
                let btn = document.createElement('a');
                btn.classList.add('btn', 'btn-primary', 'btn-lg', 'm-auto');
                btn.href = '#';
                btn.innerText = 'Reservar';
                btnContainer.appendChild(btn);
                container.appendChild(row);
                container.appendChild(btnContainer);
            }else{  //EN CASO DE NO ENCONTRAR NADA REINICIA
                latitud = 7.475430;
                longitud = -64.211732;
                zoomNum = 6;
                //Se incia el mapa con los nuevos datos
                initMap();
                //Se coloca el marcador en el mapa
                makeMarker({lat: latitud, lng: longitud});
                //Estructura del HTML
                let row = document.createElement('div');
                row.classList.add('row');
                let name = document.createElement('div');
                name.classList.add("h2", "mx-auto", "my-3");
                name.innerText = `No se ha encontrado ${op}`;
                row.appendChild(name);
                container.appendChild(row);
            }
        }
    }

});

function selectDrops(){
    selectEstado();
    selectReligion();
}

function selectReligion(){
    let peticion = new XMLHttpRequest()
    let params = `religion=all`   //PARTE DE LA URL QUE DEFINE LOS ELEMENTOS DE GET
    peticion.open('GET', `./getSites.php?${params}`)

    peticion.send()

    //loader.classList.add('active');

    peticion.onreadystatechange = function () {
        if (peticion.readyState == 4 && peticion.status == 200) {
            //loader.classList.remove('active')
        }
    }

    peticion.onload = function () {
        let data = JSON.parse(peticion.responseText)
        if(!data.error) {
            let dropReligion = document.getElementById('religion-select');
            removeAllChilds(dropReligion);
            for(d in data){
                let op = document.createElement('option');
                op.value = data[d].id;
                op.innerText = data[d].nombre;
                dropReligion.appendChild(op);
            }
            selectMunicipio();
        }else{
            alert('Error al cargar las religiones');
        }
    }
}

function selectEstado(){
    let peticion = new XMLHttpRequest()
    let params = `tipo=ESTADO`   //PARTE DE LA URL QUE DEFINE LOS ELEMENTOS DE GET
    peticion.open('GET', `./getSites.php?${params}`)

    peticion.send()

    //loader.classList.add('active');

    peticion.onreadystatechange = function () {
        if (peticion.readyState == 4 && peticion.status == 200) {
            //loader.classList.remove('active')
        }
    }

    peticion.onload = function () {
        let data = JSON.parse(peticion.responseText)
        if(!data.error) {
            let dropEstado = document.getElementById('estado-select');
            removeAllChilds(dropEstado);
            for(d in data){
                let op = document.createElement('option');
                op.value = data[d].id;
                op.innerText = data[d].nombre;
                dropEstado.appendChild(op);
            }
            selectMunicipio();
        }else{
            alert('Error al cargar los estados');
        }
    }
}

function selectMunicipio(){
    let dropEstados = document.getElementById('estado-select');

    let index = dropEstados.selectedIndex;
    let id = dropEstados[index].value;

    let peticion = new XMLHttpRequest()
    let params = `id=${id}`   //PARTE DE LA URL QUE DEFINE LOS ELEMENTOS DE GET
    peticion.open('GET', `./getSites.php?${params}`)

    peticion.send()

    //loader.classList.add('active');

    peticion.onreadystatechange = function () {
        if (peticion.readyState == 4 && peticion.status == 200) {
            //loader.classList.remove('active')
        }
    }

    peticion.onload = function () {
        let data = JSON.parse(peticion.responseText)
        if(!data.error) {
            let dropMunicipios = document.getElementById('municipio-select');
            removeAllChilds(dropMunicipios);
            for (d in data) {
                let op = document.createElement('option');
                op.value = data[d].id;
                op.innerText = data[d].nombre;
                dropMunicipios.appendChild(op);
            }
            selectParroquia();
        }else{
            alert('Error al cargar los municipios');
        }
    }
}

function selectParroquia(){
    let dropMunicipios = document.getElementById('municipio-select');

    let index = dropMunicipios.selectedIndex;
    let id = dropMunicipios[index].value;

    let peticion = new XMLHttpRequest()
    let params = `id=${id}`   //PARTE DE LA URL QUE DEFINE LOS ELEMENTOS DE GET
    peticion.open('GET', `./getSites.php?${params}`)

    peticion.send()

    //loader.classList.add('active');

    peticion.onreadystatechange = function () {
        if (peticion.readyState == 4 && peticion.status == 200) {
            //loader.classList.remove('active')
        }
    }

    peticion.onload = function () {
        let data = JSON.parse(peticion.responseText)
        if(!data.error){
            let dropParroquias = document.getElementById('parroquia-select');
            removeAllChilds(dropParroquias);
            for(d in data){
                let op = document.createElement('option');
                op.value = data[d].id;
                op.innerText = data[d].nombre;
                dropParroquias.appendChild(op);
            }
        }else{
            alert('Error al cargar las parroquias');
        }
    }
}