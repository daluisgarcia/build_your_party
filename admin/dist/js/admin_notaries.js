var dataT;

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

document.getElementById('notaria').addEventListener("click", function (event) {
  document.getElementById('title').innerText = 'Notarias';

  if(dataT){
    dataT.destroy();
  }

  document.getElementById('table_id').classList.remove('d-none');
  if(document.getElementById('addTuple')) {
    document.getElementById('addTuple').remove();
  }

  let addBtn = document.getElementsByClassName('add-btn')[0];
  addBtn.classList.remove('disabled');
  addBtn.id='add-btn-notaries';
  document.getElementById('add-btn-notaries').addEventListener('click', setAddNotaries);
  let deleteBtn = document.getElementsByClassName('delete-btn')[0];
  deleteBtn.classList.add('disabled');
  deleteBtn.id='delete-btn-notaries';
  document.getElementById('delete-btn-notaries').addEventListener('click', setDeleteNotaries);
  let submitBtn = document.getElementsByClassName('submit-btn')[0];
  submitBtn.classList.add('disabled');
  submitBtn.id='submit-btn-notaries';
  document.getElementById('submit-btn-notaries').addEventListener('click', setUpdateNotaries);
  getNotaries();
});

function getNotaries(){

  let peticion = new XMLHttpRequest();

  let  params = `option=notaria`;   //PARTE DE LA URL QUE DEFINE LOS ELEMENTOS DE GET

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
        tr2.classList.add('clickeable-notaries');
        let nombreC2 = document.createElement('td');
        nombreC2.innerText = data[d].nombre;
        nombreC2.classList.add('clickeable-notaries');
        let latC2 = document.createElement('td')
        latC2.innerText = data[d].latitud;
        latC2.id = `coord-${data[d].id_coordenada}`;
        latC2.classList.add('clickeable-notaries');
        let longC2 = document.createElement('td')
        longC2.innerText = data[d].longitud;
        longC2.classList.add('clickeable-notaries');
        let personC2 = document.createElement('td')
        personC2.innerText = data[d].persona;
        personC2.id = `person-${data[d].id_persona}`;
        personC2.classList.add('clickeable-notaries');
        let parroquiaC2 = document.createElement('td')
        parroquiaC2.innerText = data[d].nombre_parroquia;
        parroquiaC2.id = `parroquia-${data[d].id_parroquia}`;
        parroquiaC2.classList.add('clickeable-notaries');
        let municipioC2 = document.createElement('td')
        municipioC2.innerText = data[d].nombre_municipio;
        municipioC2.id = `municipio-${data[d].id_municipio}`;
        municipioC2.classList.add('clickeable-notaries');
        let estadoC2 = document.createElement('td')
        estadoC2.innerText = data[d].nombre_estado;
        estadoC2.id = `estado-${data[d].id_estado}`;
        estadoC2.classList.add('clickeable-notaries');
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
      datatable();
    }else{
      datatable();
    }
    setChangePosibilityNotaries();
  }
}

//AÑADIR A LAS FILAS LA POSIBILIDAD DE CAMBIAR LOS DATOS (AGREGAR INPUTS)
function setChangePosibilityNotaries(){
  let rows = document.getElementsByTagName('tr');
  for (let i = 0; i < rows.length; i++){
    let element = rows[i];
    if (element.id !== 'table-head'){
      element.addEventListener('click', function (event) {
        if(event.target.classList.contains('clickeable-notaries')) {
          let columns = event.target.parentElement.children;
          let names = ['nombre', 'latitud', 'longitud', 'persona'];
          for (let j = 0; j < columns.length; j++) {
            if (j < 4) {
              let input = document.createElement('input');
              input.type = 'text';
              input.name = names[j];
              input.value = columns[j].innerText;
              if(j === 0){
                input.id = element.id;
              }
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
          document.getElementById('delete-btn-notaries').classList.remove('disabled');
          document.getElementById('submit-btn-notaries').classList.remove('disabled');
        }
      })
    }
  }
}

//FUNCION PARA HACER UPDATE DE UNA NOTARIA
function setUpdateNotaries(){
  let name = document.getElementsByName('nombre')[0],
    notaryID = name.id,
    latitud = document.getElementsByName("latitud")[0],
    coordinatesID = returnIdNumber(latitud.id),
    longitud = document.getElementsByName("longitud")[0].value,
    persona = document.getElementsByName("persona")[0],
    personaID = returnIdNumber(persona.id),
    parroquiaID = document.getElementsByName("parroquia")[0].value;

  latitud = latitud.value;
  persona = persona.value;
  let index = persona.indexOf(' ')+1;
  let persona2 = persona.substr(index, persona.length-index);
  persona = persona.substr(0, index);
  name = name.value;

  let peticion = new XMLHttpRequest()
  let params = `option=update&id=${notaryID}&name=${name}&fklugar=${parroquiaID}&coordID=${coordinatesID}&latitud=${latitud}&longitud=${longitud}&personid=${personaID}&personname1=${persona}&personname2=${persona2}`;   //PARTE DE LA URL QUE DEFINE LOS ELEMENTOS DE GET
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
    if(data.error){
      alert('Error al obtener datos de la Base');
    }else{
      getNotaries();
    }
  }
}

//FUNCION PARA ELIMINAR UNA NOTARIA
function setDeleteNotaries(){
  let notaryID = document.getElementsByName('nombre')[0].id,
    coordinatesID = document.getElementsByName("latitud")[0].id,
    personaID = document.getElementsByName("persona")[0].id;

  let peticion = new XMLHttpRequest()
  let params = `option=delete&id=${notaryID}&coordID=${coordinatesID}&personid=${personaID}`;   //PARTE DE LA URL QUE DEFINE LOS ELEMENTOS DE GET
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
    if(data.error){
      alert('Error al obtener datos de la Base');
    }else{
      getNotaries();
    }
  }
}

//FUNCION PARA CREACION DE FORMULARIO Y AGREGAR UNA NOTARIA
function setAddNotaries(){
  let tableDiv = document.getElementById('table_id');
  dataT.destroy();
  removeAllChilds(tableDiv);
  tableDiv.classList.add('d-none');

  let form = document.createElement('form');
  form.id = 'addTuple';
  let nameLabel = document.createElement('label');
  nameLabel.setAttribute('for', 'nombre-notaria');
  nameLabel.innerText = 'Nombre notaria';
  form.appendChild(nameLabel);
  let name = document.createElement('input');
  name.id='nombre-notaria';
  name.name = 'nombre-notaria';
  form.appendChild(name);
  let cedulaLabel = document.createElement('label');
  cedulaLabel.setAttribute('for', 'cedula');
  cedulaLabel.innerText = 'Cedula Notario';
  form.appendChild(cedulaLabel);
  let cedula = document.createElement('input');
  cedula.id='cedula';
  cedula.name = 'cedula';
  form.appendChild(cedula);
  let codigoALabel = document.createElement('label');
  codigoALabel.setAttribute('for', 'codigo-area');
  codigoALabel.innerText = 'Código de área';
  form.appendChild(codigoALabel);
  let codigoA = document.createElement('input');
  codigoA.id='codigo-area';
  codigoA.name = 'codigo-area';
  form.appendChild(codigoA);
  let telefonoLabel = document.createElement('label');
  telefonoLabel.setAttribute('for', 'telefono');
  telefonoLabel.innerText = 'Número de teléfono';
  form.appendChild(telefonoLabel);
  let telefono = document.createElement('input');
  telefono.id='telefono';
  telefono.name = 'telefono';
  form.appendChild(telefono);
  let latitudLabel = document.createElement('label');
  latitudLabel.setAttribute('for', 'latitud');
  latitudLabel.innerText = 'Latitud';
  form.appendChild(latitudLabel);
  let latitud = document.createElement('input');
  latitud.id='latitud';
  latitud.name = 'latitud';
  form.appendChild(latitud);
  let longitudLabel = document.createElement('label');
  longitudLabel.setAttribute('for', 'longitud');
  longitudLabel.innerText = 'Longitud';
  form.appendChild(longitudLabel);
  let longitud = document.createElement('input');
  longitud.id='longitud';
  longitud.name = 'longitud';
  form.appendChild(longitud);
  let input3Label = document.createElement('label');
  input3Label.setAttribute('for', 'estado-select');
  input3Label.innerText = 'Estado';
  form.appendChild(input3Label);
  let input3 = document.createElement('select');
  input3.id = 'estado-select';
  input3.name = 'estado';
  input3.setAttribute('onchange','selectMunicipio()');
  form.appendChild(input3);
  let input2Label = document.createElement('label');
  input2Label.setAttribute('for', 'municipio-select');
  input2Label.innerText = 'Municipio';
  form.appendChild(input2Label);
  let input2 = document.createElement('select');
  input2.id = 'municipio-select';
  input2.name = 'municipio';
  input2.setAttribute('onchange','selectParroquia()');
  form.appendChild(input2);
  let input1Label = document.createElement('label');
  input1Label.setAttribute('for', 'parroquia-select');
  input1Label.innerText = 'Parroquia';
  form.appendChild(input1Label);
  let input1 = document.createElement('select');
  input1.id = 'parroquia-select';
  input1.name = 'parroquia';
  form.appendChild(input1);
  selectEstado();
  let submit = document.createElement('button');
  submit.id = 'submit-change';
  submit.classList.add('btn', 'btn-primary');
  submit.innerText='Agregar Notaria';
  form.appendChild(submit);
  document.getElementById('container').appendChild(form);

  submit.addEventListener('click', function () {

    let name = document.getElementById('nombre-notaria').value,
      cedula = document.getElementById('cedula').value,
      codigo = document.getElementById('codigo-area').value,
      telefono = document.getElementById('telefono').value,
      latitud = document.getElementById('latitud').value,
      longitud = document.getElementById('longitud').value,
      parroquia = document.getElementById('parroquia-select').value;

    let peticion = new XMLHttpRequest()
    let params = `option=create&name=${name}&fklugar=${parroquia}&latitud=${latitud}&longitud=${longitud}&personid=${cedula}&codigoarea=${codigo}&telefono=${telefono}`;

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
      if(data.error){
        alert('Error al introducir datos');
      }else{
        document.getElementById('table_id').classList.remove('d-none');
        document.getElementById('addTuple').remove();
        getNotaries();
      }
    }
  })
}
