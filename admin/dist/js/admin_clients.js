
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

document.getElementById('cliente').addEventListener('click', function (event) {
  document.getElementById('title').innerText = 'Clientes';

  if(dataT){
    dataT.destroy();
  }

  document.getElementById('table_id').classList.remove('d-none');
  if(document.getElementById('addTuple')) {
    document.getElementById('addTuple').remove();
  }

  let addBtn = document.getElementsByClassName('add-btn')[0];
  addBtn.classList.remove('disabled');
  addBtn.id='add-btn-clients';
  let deleteBtn = document.getElementsByClassName('delete-btn')[0];
  deleteBtn.classList.add('disabled');
  deleteBtn.id='delete-btn-clients';
  let submitBtn = document.getElementsByClassName('submit-btn')[0];
  submitBtn.classList.add('disabled');
  submitBtn.id='submit-btn-clients';
  getClients();
});

function getClients() {

  let peticion = new XMLHttpRequest()
  let params = `option=select`   //PARTE DE LA URL QUE DEFINE LOS ELEMENTOS DE GET
  peticion.open('GET', `./consult_clients.php?${params}`)

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
    let cedula = document.createElement('td')
    cedula.innerText = 'Cedula';
    let nombre = document.createElement('td')
    nombre.innerText = 'Nombre';
    let apellido = document.createElement('td')
    apellido.innerText = 'Apellido';
    let correo = document.createElement('td')
    correo.innerText = 'Correo';
    let codigo_de_area = document.createElement('td')
    codigo_de_area.innerText = 'Codigo de area telefono';
    let numero = document.createElement('td')
    numero.innerText = 'Numero telefono';
    let usuario = document.createElement('td')
    usuario.innerText = 'Usuario';
    let parroquiaC = document.createElement('td')
    parroquiaC.innerText = 'Parroquia';
    let municipioC = document.createElement('td')
    municipioC.innerText = 'Municipio';
    let estadoC = document.createElement('td')
    estadoC.innerText = 'Estado';
    tr1.appendChild(cedula);
    tr1.appendChild(nombre);
    tr1.appendChild(apellido);
    tr1.appendChild(correo);
    tr1.appendChild(codigo_de_area);
    tr1.appendChild(numero);
    tr1.appendChild(usuario);
    tr1.appendChild(parroquiaC);
    tr1.appendChild(municipioC);
    tr1.appendChild(estadoC);
    thead.appendChild(tr1);
    let tbody = document.createElement('tbody');
    if(!data.error){
      for(d in data) {
        let tr2 = document.createElement('tr');
        tr2.id = data[d].cedula;
        tr2.classList.add('clickeable-clients');

        let cedulaC2 = document.createElement('td');
        cedulaC2.innerText = data[d].cedula;
        cedulaC2.id = `cedula-${data[d].cedula}`;
        cedulaC2.classList.add('clickeable-clients');

        let nombreC2 = document.createElement('td')
        nombreC2.innerText = data[d].nombre;
        nombreC2.classList.add('clickeable-clients');

        let apellidoC2 = document.createElement('td')
        apellidoC2.innerText = data[d].apellido;
        apellidoC2.classList.add('clickeable-clients');

        let correoC2 = document.createElement('td')
        correoC2.innerText = data[d].correo;
        correoC2.classList.add('clickeable-clients');

        let codigoC2 = document.createElement('td')
        codigoC2.innerText = data[d].codigo_de_area;
        codigoC2.id = `codigo_area-${data[d].telefono_id}`;
        codigoC2.classList.add('clickeable-clients');

        let numeroC2 = document.createElement('td')
        numeroC2.innerText = data[d].numero;
        numeroC2.id = `numero-${data[d].telefono_id}`;
        numeroC2.classList.add('clickeable-clients');

        let usuarioC2 = document.createElement('td')
        usuarioC2.innerText = data[d].usuario;
        usuarioC2.id = `usuario-${data[d].usuario_id}`;
        usuarioC2.classList.add('clickeable-clients');

        let parroquiaC2 = document.createElement('td')
        parroquiaC2.innerText = data[d].parroquia;
        parroquiaC2.id = `parroquia-${data[d].parroquia_id}`;
        parroquiaC2.classList.add('clickeable-clients');

        let municipioC2 = document.createElement('td')
        municipioC2.innerText = data[d].municipio;
        municipioC2.id = `municipio-${data[d].municipio_id}`;
        municipioC2.classList.add('clickeable-clients');

        let estadoC2 = document.createElement('td')
        estadoC2.innerText = data[d].estado;
        estadoC2.id = `estado-${data[d].estado_id}`;
        estadoC2.classList.add('clickeable-clients');

        tr2.appendChild(cedulaC2);
        tr2.appendChild(nombreC2);
        tr2.appendChild(apellidoC2);
        tr2.appendChild(correoC2);
        tr2.appendChild(codigoC2);
        tr2.appendChild(numeroC2);
        tr2.appendChild(usuarioC2);
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
    setChangePosibilityClients();
  }
};

//AÑADIR A LAS FILAS LA POSIBILIDAD DE CAMBIAR LOS DATOS
function setChangePosibilityClients(){
  let rows = document.getElementsByTagName('tr');
  for (let i = 0; i < rows.length; i++){
    let element = rows[i];
    if (element.id !== 'table-head'){
      element.addEventListener('click', function (event) {
        if(event.target.classList.contains('clickeable-clients')) {
          let columns = event.target.parentElement.children;
          let names = ['cedula','nombre','apellido', 'correo', 'codigo', 'numero', 'usuario'];
          for (let j = 0; j < columns.length; j++) {
            if (j < 7) {
              let input = document.createElement('input');
              input.type = 'text';
              input.name = names[j];
              input.value = columns[j].innerText;
              if((j === 0) || (j === 4) || (j === 5) || (j === 6)){
                input.id = element.id;
              }
              console.log(j);
              console.log(columns[j]);
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
              console.log(j);
              console.log(columns[j]);
              columns[j].appendChild(input1);
              let op1 = returnIdNumber(columns[j].id);
              console.log('return id number');
              console.log(op1);

              let input2 = document.createElement('select');
              input2.id = 'municipio-select';
              input2.name = 'municipio';
              input2.setAttribute('onchange','selectParroquia()');
              columns[j + 1].innerText = '';
              columns[j + 1].appendChild(input2);
              let op2 = returnIdNumber(columns[j+1].id);
              console.log('id param');
              console.log(columns[j+1].id);
              console.log('return id number 2');
              console.log(op2);

              let input3 = document.createElement('select');
              input3.id = 'estado-select';
              input3.name = 'estado';
              input3.setAttribute('onchange','selectMunicipio()');
              columns[j + 2].innerText = '';
              columns[j + 2].appendChild(input3);
              let op3 = returnIdNumber(columns[j+2].id);
              console.log('return id number 3');
              console.log(op3);

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
          document.getElementById('delete-btn-clients').classList.remove('disabled');
          document.getElementById('submit-btn-clients').classList.remove('disabled');
        }
      })
    }
  }
}
