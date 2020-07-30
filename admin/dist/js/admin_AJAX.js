var dataT;
var page;

//INICIALIZACION DE DATATABLE
function datatable() {
  $(document).ready(function () {
    dataT = $('#table_id').DataTable({
      "language": {
        "lengthMenu": "Motrar _MENU_ registros",
        "zeroRecords": "No se encontraron resultados",
        "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
        "infoFiltered": "(filtrado de un total de _MAX_ registros)",
        "sSearch": "Buscar",
        "oPaginate": {
          "sFirst": "Primero",
          "sLast": "Último",
          "sNext": "Siguiente",
          "sPrevious": "Anterior"
        },
        "sProcessing": "Procesando..."
      }
    });
  });
}

function removeAllChilds(element) {
  let child = element.lastChild;
  while(child){
    element.removeChild(child);
    child = element.lastChild;
  }
}

function returnIdNumber(id) {
  let index = id.indexOf('-')+1;
  return id.substr(index, id.length-index);
}

function selectEstado(){
  return new Promise((resolve, reject) => {
    let peticion = new XMLHttpRequest()
    let params = `tipo=ESTADO`   //PARTE DE LA URL QUE DEFINE LOS ELEMENTOS DE GET
    peticion.open('GET', `../getSites.php?${params}`)

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
        let promise = selectMunicipio();
        promise.then(()=>{
          resolve();
        }).catch(()=>{
          reject();
        })
      }else{
        alert('Error al cargar los estados');
        reject();
      }
    }
  })
}

function selectMunicipio(){
  return new Promise((resolve, reject) => {
    let dropEstados = document.getElementById('estado-select');

    let id = dropEstados.value;

    let peticion = new XMLHttpRequest()
    let params = `id=${id}`   //PARTE DE LA URL QUE DEFINE LOS ELEMENTOS DE GET
    peticion.open('GET', `../getSites.php?${params}`)

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
        let promise = selectParroquia();
        promise.then(() => {
          resolve();
        }).catch(() => {
          reject();
        })
      }else{
        alert('Error al cargar los municipios');
        reject();
      }
    }
  })
}

function selectParroquia(){
  return new Promise((resolve, reject) => {
    let dropMunicipios = document.getElementById('municipio-select');

    let id = dropMunicipios.value;

    let peticion = new XMLHttpRequest()
    let params = `id=${id}`   //PARTE DE LA URL QUE DEFINE LOS ELEMENTOS DE GET
    peticion.open('GET', `../getSites.php?${params}`)

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
        resolve();
      }else{
        alert('Error al cargar las parroquias');
        reject();
      }
    }
  })
}

//SE LE ASIGNA A CADA OPCION DE LA BARRA VERTICAL IZQUIERA UN EVENTO PARA PODER CARGAR EL AJAX
var menuOption = document.getElementsByClassName('option');
for (let i = 0; i < option.length; i++) {
  menuOption[i].addEventListener('click', function (event) {

    let op = event.target.id;
    page = op;

    document.getElementById('add-btn').classList.remove('disabled');
    document.getElementById('delete-btn').classList.add('disabled');
    document.getElementById('submit-btn').classList.add('disabled');

    switch (op) {
      case 'notaria':
        getNotaries(op);
        break;
      case 'jefatura':
        break;
      case 'templo':
        break;
      default:

    }

  });
}

function getNotaries(op) {

  document.getElementById('title').innerText = 'Notarias';

  let peticion = new XMLHttpRequest()
  let params = '';

  if(op === 'notaria'){
    params = `option=${op}`   //PARTE DE LA URL QUE DEFINE LOS ELEMENTOS DE GET
  }else{
    params = `option=`   //PARTE DE LA URL QUE DEFINE LOS ELEMENTOS DE GET
  }
  peticion.open('GET', `./info_getter.php?${params}`)

  peticion.send()

  //loader.classList.add('active');

  peticion.onreadystatechange = function () {
    if (peticion.readyState == 4 && peticion.status == 200) {
      //loader.classList.remove('active')
    }
  }

  peticion.onload = function () {
    let data = JSON.parse(peticion.responseText);
    let container = document.getElementById('table_id');
    removeAllChilds(container);
    let thead = document.createElement('thead');
    let tr1 = document.createElement('tr');
    tr1.id = 'table-head';
    let nombreC = document.createElement('td')
    nombreC.innerText = 'Nombre';
    let latC = document.createElement('td')
    latC.innerText = 'Latitud';
    let longC = document.createElement('td')
    longC.innerText = 'Longitud';
    let personC = document.createElement('td')
    personC.innerText = 'Notario';
    let parroquiaC = document.createElement('td')
    parroquiaC.innerText = 'Parroquia';
    let municipioC = document.createElement('td')
    municipioC.innerText = 'Municipio';
    let estadoC = document.createElement('td')
    estadoC.innerText = 'Estado';
    tr1.appendChild(nombreC);
    tr1.appendChild(latC);
    tr1.appendChild(longC);
    tr1.appendChild(personC);
    tr1.appendChild(parroquiaC);
    tr1.appendChild(municipioC);
    tr1.appendChild(estadoC);
    thead.appendChild(tr1);
    let tbody = document.createElement('tbody');
    if(!data.error){
      for(d in data) {
        let tr2 = document.createElement('tr');
        tr2.id = data[d].id;
        tr2.classList.add('clickeable');
        let nombreC2 = document.createElement('td');
        nombreC2.innerText = data[d].nombre;
        nombreC2.classList.add('clickeable');
        let latC2 = document.createElement('td')
        latC2.innerText = data[d].latitud;
        latC2.id = `coord-${data[d].id_coordenada}`;
        latC2.classList.add('clickeable');
        let longC2 = document.createElement('td')
        longC2.innerText = data[d].longitud;
        longC2.classList.add('clickeable');
        let personC2 = document.createElement('td')
        personC2.innerText = data[d].persona;
        personC2.id = `person-${data[d].id_persona}`;
        personC2.classList.add('clickeable');
        let parroquiaC2 = document.createElement('td')
        parroquiaC2.innerText = data[d].nombre_parroquia;
        parroquiaC2.id = `parroquia-${data[d].id_parroquia}`;
        parroquiaC2.classList.add('clickeable');
        let municipioC2 = document.createElement('td')
        municipioC2.innerText = data[d].nombre_municipio;
        municipioC2.id = `municipio-${data[d].id_municipio}`;
        municipioC2.classList.add('clickeable');
        let estadoC2 = document.createElement('td')
        estadoC2.innerText = data[d].nombre_estado;
        estadoC2.id = `estado-${data[d].id_estado}`;
        estadoC2.classList.add('clickeable');
        tr2.appendChild(nombreC2);
        tr2.appendChild(latC2);
        tr2.appendChild(longC2);
        tr2.appendChild(personC2);
        tr2.appendChild(parroquiaC2);
        tr2.appendChild(municipioC2);
        tr2.appendChild(estadoC2);
        tbody.appendChild(tr2);
      }
    }
    container.appendChild(thead);
    container.appendChild(tbody);
    if(dataT) {
      dataT.destroy();
    }
    datatable();
    setChangePosibility();
  }
};

//AÑADIR A LAS FILAS LA POSIBILIDAD DE CAMBIAR LOS DATOS
async function setChangePosibility(){
  let rows = document.getElementsByTagName('tr');
  for (let i = 0; i < rows.length; i++){
    let element = rows[i];
    if (element.id !== 'table-head'){
      element.addEventListener('click', function (event) {
        if(event.target.classList.contains('clickeable')) {
          let columns = event.target.parentElement.children;
          let names = ['nombre', 'latitud', 'longitud', 'persona'];
          for (let j = 0; j < columns.length; j++) {
            if (j < 4) {
              let input = document.createElement('input');
              input.type = 'text';
              input.name = names[j];
              input.value = columns[j].innerText;
              columns[j].innerText = '';
              if(columns[j].id){
                input.id = columns[j].id;
              }
              columns[j].appendChild(input);
            } else {
              let input1 = document.createElement('select');
              input1.id = 'parroquia-select';
              input1.name = 'parroquia';
              columns[j].innerText = '';
              columns[j].appendChild(input1);
              let op1 = returnIdNumber(columns[j].id);

              let input2 = document.createElement('select');
              input2.id = 'municipio-select';
              input2.name = 'municipio';
              input2.setAttribute('onchange','selectParroquia()');
              columns[j + 1].innerText = '';
              columns[j + 1].appendChild(input2);
              let op2 = returnIdNumber(columns[j+1].id);

              let input3 = document.createElement('select');
              input3.id = 'estado-select';
              input3.name = 'estado';
              input3.setAttribute('onchange','selectMunicipio()');
              columns[j + 2].innerText = '';
              columns[j + 2].appendChild(input3);
              let op3 = returnIdNumber(columns[j+2].id);

              let promise1 = selectEstado();
              promise1.then(() => {
                input3.value = op3;
                let promise2 = selectMunicipio();
                promise2.then(() => {
                  input2.value = op2;
                  let promise3 = selectParroquia();
                  promise3.then(() => {
                    input1.value = op1;
                  }).catch(() => {
                    console.log('ERROR CON PARROQUIAS');
                  })
                }).catch(() => {
                  console.log('ERROR CON MUNICIPIOS');
                })
              }).catch(() => {
                console.log('ERROR CON ESTADOS');
              })
              j = j + 2;
            }

          }
          document.getElementById('delete-btn').classList.remove('disabled');
          document.getElementById('submit-btn').classList.remove('disabled');
        }
      })
    }
  }
}

document.getElementById('submit-btn').addEventListener('click', function (event) {

  event.preventDefault() //IMPIDE QUE SE ENVIE EN FORMULARIO AUTOMATICAMENTE

  let name = document.getElementsByName('nombre')[0].value,
    latitud = document.getElementsByName("latitud"),
    coordinatesID = returnIdNumber(latitud[0].id),
    longitud = document.getElementsByName("longitud")[0].value,
    persona = document.getElementsByName("persona"),
    personaID = returnIdNumber(persona[0].id),
    parroquiaID = document.getElementsByName("parroquia")[0].value;

    latitud = latitud[0].value;
    persona = persona[0].value;

    let peticion = new XMLHttpRequest()
    let params = `option=${page}&name=${name}&fklugar=${parroquiaID}&coordID=${coordinatesID}&latitud=${latitud}&longitud=${longitud}&personid=${personaID}&personname1=${persona}&personname2=${persona}`   //PARTE DE LA URL QUE DEFINE LOS ELEMENTOS DE GET
    peticion.open('GET', `./update.php?${params}`)

    peticion.send()

    //loader.classList.add('active');

    peticion.onreadystatechange = function(){
      if(peticion.readyState == 4 && peticion.status == 200){
        //loader.classList.remove('active')
      }
    }

    peticion.onload = function(){
      let data = JSON.parse(peticion.responseText)
      let container = document.getElementById('content');
      removeAllChilds(container);
      if(data.error){
        let element = document.createElement('p')
        element.innerText = data.error
        document.getElementById('no-content').appendChild(element)
      }else{
        for(let i = 0; i < data.length; i++){
          container.appendChild(showContent(data[i]))
        }
      }
      document.getElementById("search").value = ""
      document.getElementById("category").value = "default"
      document.getElementById("feature").value = "default"
    }


})
