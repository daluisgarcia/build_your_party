
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
    let rolesC = document.createElement('td')
    rolesC.innerText = 'Roles';
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
    tr1.appendChild(rolesC);
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

        let rolC2 = document.createElement('select');
        rolC2.id = `drop-${data[d].usuario}`;
        rolC2.name = 'rol';

        let promise = rolesForUser(data[d].usuario_id, `drop-${data[d].usuario}`);
        promise.then(() => {
        }).catch(() => {
          console.log('ERROR CON PERMISOS');
        })


        let agregarC2 = document.createElement('button')
        agregarC2.id = `agregar-${data[d].usuario_id}`;
        agregarC2.classList.add('btn', 'btn-primary', 'm-2');
        agregarC2.innerText='Asignar Rol';
        agregarC2.addEventListener('click', function () {
          let user = returnIdNumber(agregarC2.id);
          newRoleUser(user)
        })

        let eliminarC2 = document.createElement('button')
        eliminarC2.id = `eliminar-${data[d].usuario_id}`;
        eliminarC2.classList.add('btn', 'btn-danger', 'm-2');
        eliminarC2.innerText='Eliminar Rol';
        eliminarC2.addEventListener('click', function () {
          let user = returnIdNumber(eliminarC2.id);
          deleteRoleUser(user)
        })

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
        tr2.appendChild(rolC2);
        tr2.appendChild(agregarC2);
        tr2.appendChild(eliminarC2);
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

function deleteRoleUser(user) {
  console.log('borrar permiso a usuario '+user);
  let tableDiv = document.getElementById('table_id');
  //dataT.destroy();
  removeAllChilds(tableDiv);
  tableDiv.classList.add('d-none');

  let form = document.createElement('form');
  form.id = 'addTuple';

  let userLabel = document.createElement('label');
  userLabel.setAttribute('for', 'user-label');
  userLabel.innerText = 'Usuario:';
  form.appendChild(userLabel);
  let username = document.createElement('label');
  username.setAttribute('for', 'username-label');
  username.id = 'username-label';
  form.appendChild(username);

  let userPromise = getUser(user);
  userPromise.then(() => {
  }).catch(() => {
    console.log('ERROR CON PERMISOS');
  })

  let userroles = document.createElement('label');
  userroles.setAttribute('for', 'role-to-select');
  userroles.innerText = 'Rol';
  form.appendChild(userroles);
  let role = document.createElement('select');
  role.id = `select-rol-${user}`;
  role.name = 'rol';
  form.appendChild(role);

  let rolPromise = rolesForUser(user, role.id);
  rolPromise.then(() => {
  }).catch(() => {
    console.log('ERROR CON PERMISOS');
  })

  let submit = document.createElement('button');
  submit.id = 'submit-change-rp';
  submit.classList.add('btn', 'btn-primary');
  submit.innerText='Desvincular';
  form.appendChild(submit);
  document.getElementById('container').appendChild(form);

  submit.addEventListener('click', function () {

    let rol = document.getElementById(`select-rol-${user}`).value;

    let peticion = new XMLHttpRequest()
    let params = `option=take&rol=${rol}&id_usuario=${user}`;
    console.log(params);
    peticion.open('GET', `./consult_clients.php?${params}`)

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
        getClients();
      }
    }
  })
}


function rolesForUser(user, drop) {
  return new Promise((resolve, reject) => {
    let peticion = new XMLHttpRequest()
    let params = `option=myroles&id_usuario=${user}`   //PARTE DE LA URL QUE DEFINE LOS ELEMENTOS DE GET
    peticion.open('GET', `./consult_clients.php?${params}`)

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
        let dropRoles = document.getElementById(drop);
        removeAllChilds(dropRoles);
        for(d in data){
          let op = document.createElement('option');
          op.value = data[d].id_rol;
          op.innerText = data[d].nombre_rol;
          dropRoles.appendChild(op);
        }
        resolve();
      }else{
        //alert('Error al cargar los estados');
        reject();
      }
    }
  })
}

function newRoleUser(user) {
  let tableDiv = document.getElementById('table_id');
  //dataT.destroy();
  removeAllChilds(tableDiv);
  tableDiv.classList.add('d-none');

  let form = document.createElement('form');
  form.id = 'addTuple';

  let userLabel = document.createElement('label');
  userLabel.setAttribute('for', 'user-label');
  userLabel.innerText = 'Usuario:';
  form.appendChild(userLabel);
  let username = document.createElement('label');
  username.setAttribute('for', 'username-label');
  username.id = 'username-label';
  form.appendChild(username);

  let userPromise = getUser(user);
  userPromise.then(() => {
  }).catch(() => {
    console.log('ERROR CON PERMISOS');
  })

  let allroles = document.createElement('label');
  allroles.setAttribute('for', 'role-to-select');
  allroles.innerText = 'Rol';
  form.appendChild(allroles);
  let role = document.createElement('select');
  role.id = 'select-rol';
  role.name = 'rol';
  form.appendChild(role);

  let rolPromise = selectAllRoles();
  rolPromise.then(() => {
  }).catch(() => {
    console.log('ERROR CON PERMISOS');
  })

  let submit = document.createElement('button');
  submit.id = 'submit-change-rp';
  submit.classList.add('btn', 'btn-primary');
  submit.innerText='Asociar';
  form.appendChild(submit);
  document.getElementById('container').appendChild(form);

  submit.addEventListener('click', function () {

    let rol = document.getElementById('select-rol').value;

    let peticion = new XMLHttpRequest()
    let params = `option=give&rol=${rol}&id_usuario=${user}`;
    console.log(params);
    peticion.open('GET', `./consult_clients.php?${params}`)

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
        getClients();
      }
    }
  })
};

function getUser(user) {
  return new Promise((resolve, reject) => {
    let peticion = new XMLHttpRequest()
    let params = `option=specific&id_usuario=${user}`   //PARTE DE LA URL QUE DEFINE LOS ELEMENTOS DE GET
    console.log("for get"+params);
    peticion.open('GET', `./consult_clients.php?${params}`)

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
        let username = document.getElementById('username-label');
        for(d in data){
          username.innerText = data[d].username;
        }
        resolve();
      }else{
        //alert('Error al cargar los estados');
        reject();
      }
    }
  })
}

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
            if (j> 9) {
              continue;
            }
            if (j < 7) {
              let input = document.createElement('input');
              input.type = 'text';
              input.name = names[j];
              input.value = columns[j].innerText;
              if((j === 0) || (j === 4) || (j === 5) || (j === 6)){
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
          document.getElementById('delete-btn-clients').classList.remove('disabled');
          document.getElementById('submit-btn-clients').classList.remove('disabled');
        }
      })
    }
  }
}

document.getElementById('cliente').addEventListener("click", function (event) {
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
  document.getElementById('add-btn-clients').addEventListener('click', setAddClients);
  let deleteBtn = document.getElementsByClassName('delete-btn')[0];
  deleteBtn.classList.add('disabled');
  deleteBtn.id='delete-btn-clients';
  document.getElementById('delete-btn-clients').addEventListener('click', setDeleteClients);
  let submitBtn = document.getElementsByClassName('submit-btn')[0];
  submitBtn.classList.add('disabled');
  submitBtn.id='submit-btn-clients';
  document.getElementById('submit-btn-clients').addEventListener('click', setUpdateClients);
  getClients();
});

//FUNCION PARA CREACION DE FORMULARIO Y AGREGAR UN CLIENTE
function setAddClients(){
  let tableDiv = document.getElementById('table_id');
  //dataT.destroy();
  removeAllChilds(tableDiv);
  tableDiv.classList.add('d-none');

  let form = document.createElement('form');
  form.id = 'addTuple';

  let cedulaLabel = document.createElement('label');
  cedulaLabel.setAttribute('for', 'cedula');
  cedulaLabel.innerText = 'Cedula cliente';
  form.appendChild(cedulaLabel);

  let cedula = document.createElement('input');
  cedula.id='cedula';
  cedula.name = 'cedula';
  form.appendChild(cedula);

  let nameLabel = document.createElement('label');
  nameLabel.setAttribute('for', 'nombre-cliente');
  nameLabel.innerText = 'Nombre cliente';
  form.appendChild(nameLabel);

  let name = document.createElement('input');
  name.id='nombre-cliente';
  name.name = 'nombre-cliente';
  form.appendChild(name);

  let apellidoLabel = document.createElement('label');
  apellidoLabel.setAttribute('for', 'apellido-cliente');
  apellidoLabel.innerText = 'Apellido cliente';
  form.appendChild(apellidoLabel);

  let apellido = document.createElement('input');
  apellido.id='apellido-cliente';
  apellido.name = 'apellido-cliente';
  form.appendChild(apellido);

  let correoLabel = document.createElement('label');
  correoLabel.setAttribute('for', 'correo-cliente');
  correoLabel.innerText = 'Correo cliente';
  form.appendChild(correoLabel);

  let correo = document.createElement('input');
  correo.id='correo-cliente';
  correo.name = 'correo-cliente';
  form.appendChild(correo);

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

  let usuarioLabel = document.createElement('label');
  usuarioLabel.setAttribute('for', 'usuario');
  usuarioLabel.innerText = 'Usuario';
  form.appendChild(usuarioLabel);
  let usuario = document.createElement('input');
  usuario.id='usuario';
  usuario.name = 'usuario';
  form.appendChild(usuario);

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
  submit.id = 'submit-change-client';
  submit.classList.add('btn', 'btn-primary');
  submit.innerText='Agregar Cliente';
  form.appendChild(submit);
  document.getElementById('container').appendChild(form);

  submit.addEventListener('click', function () {

    let cedula = document.getElementById('cedula').value,
      nombre = document.getElementById('nombre-cliente').value,
      apellido = document.getElementById('apellido-cliente').value,
      correo = document.getElementById('correo-cliente').value,
      codigo = document.getElementById('codigo-area').value,
      telefono = document.getElementById('telefono').value,
      usuario = document.getElementById('usuario').value,
      parroquia = document.getElementById('parroquia-select').value;

    let peticion = new XMLHttpRequest()
    let params = `option=create&cedula=${cedula}&nombre=${nombre}&apellido=${apellido}&correo=${correo}&codigoarea=${codigo}&telefono=${telefono}&usuario=${usuario}&parroquia=${parroquia}`;
    peticion.open('GET', `./consult_clients.php?${params}`)

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
        getClients();
      }
    }
  })
}

//FUNCION PARA HACER UPDATE DE UNA NOTARIA
function setUpdateClients(){
  let cedula = document.getElementsByName('cedula')[0].id,
    nombre = document.getElementsByName('nombre')[0].value,
    apellido = document.getElementsByName('apellido')[0].value,
    correo = document.getElementsByName('correo')[0].value,
    codigo = document.getElementsByName('codigo')[0].value,
    numero = document.getElementsByName('numero')[0].value,
    telefonoID = document.getElementsByName('numero')[0].id,
    usuario = document.getElementsByName("usuario")[0].value,
    usuarioID = document.getElementsByName("usuario")[0].id,
    parroquia = document.getElementsByName("parroquia")[0].value;

  cedula = returnIdNumber(cedula);
  usuarioID = returnIdNumber(usuarioID);
  telefonoID = returnIdNumber(telefonoID);

  let peticion = new XMLHttpRequest()
  let params = `option=update&cedula=${cedula}&nombre=${nombre}&apellido=${apellido}&correo=${correo}&codigoarea=${codigo}&telefono=${numero}&usuario=${usuario}&id_usuario=${usuarioID}&id_telefono=${telefonoID}&parroquia=${parroquia}`;   //PARTE DE LA URL QUE DEFINE LOS ELEMENTOS DE GET
  peticion.open('GET', `./consult_clients.php?${params}`)

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
      getClients();
    }
  }
}

//FUNCION PARA ELIMINAR UNA NOTARIA
function setDeleteClients(){
  let cedula = document.getElementsByName('cedula')[0].id,
    usuarioID = document.getElementsByName("usuario")[0].id

  cedula = returnIdNumber(cedula);
  usuarioID = returnIdNumber(usuarioID);

  let peticion = new XMLHttpRequest()
  let params = `option=delete&cedula=${cedula}&id_usuario=${usuarioID}`;   //PARTE DE LA URL QUE DEFINE LOS ELEMENTOS DE GET
  peticion.open('GET', `./consult_clients.php?${params}`)

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
      getClients();
    }
  }
}


