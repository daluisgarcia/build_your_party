
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

function selectPermisos(rol, drop) {
  return new Promise((resolve, reject) => {
    let peticion = new XMLHttpRequest()
    let params = `option=permisos&rol=${rol}`   //PARTE DE LA URL QUE DEFINE LOS ELEMENTOS DE GET
    peticion.open('GET', `./consult_roles.php?${params}`)

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
        let dropPermisos = document.getElementById(drop);
        removeAllChilds(dropPermisos);
        for(d in data){
          let op = document.createElement('option');
          op.value = data[d].id;
          op.innerText = data[d].nombre;
          dropPermisos.appendChild(op);
        }
        resolve();
      }else{
        //alert('Error al cargar los estados');
        reject();
      }
    }
  })
}

function getRoles() {
  let peticion = new XMLHttpRequest()
  let params = `option=select`   //PARTE DE LA URL QUE DEFINE LOS ELEMENTOS DE GET
  peticion.open('GET', `./consult_roles.php?${params}`)

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
    let rol = document.createElement('td')
    rol.innerText = 'Rol';
    let permisos = document.createElement('td')
    permisos.innerText = 'Permisos';
    let agregar = document.createElement('button')
    agregar.id = 'check-permisos';
    agregar.classList.add('btn', 'btn-primary', 'm-2');
    agregar.innerText='Asignar Permiso';
    agregar.addEventListener('click', newAssociation);
    tr1.appendChild(rol);
    tr1.appendChild(permisos);
    tr1.appendChild(agregar);
    thead.appendChild(tr1);
    let tbody = document.createElement('tbody');
    if(!data.error){
      for(d in data) {
        let tr2 = document.createElement('tr');
        tr2.id = data[d].id;
        tr2.classList.add('clickeable-roles');

        let rolC2 = document.createElement('td')
        rolC2.innerText = data[d].rol;
        rolC2.id = `rol-${data[d].id}`;
        rolC2.classList.add('clickeable-roles');

        let permisosC2 = document.createElement('select');
        permisosC2.id = `permiso-${data[d].id}`;
        permisosC2.name = 'permisos';

        let promise = selectPermisos(data[d].id, permisosC2.id);
        promise.then(() => {
        }).catch(() => {
          console.log('ERROR CON PERMISOS');
        })

        tr2.appendChild(rolC2);
        tr2.appendChild(permisosC2);
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
    setChangePosibilityRoles();
  }
};

function newAssociation() {
  let tableDiv = document.getElementById('table_id');
  //dataT.destroy();
  removeAllChilds(tableDiv);
  tableDiv.classList.add('d-none');

  let form = document.createElement('form');
  form.id = 'addTuple';

  let rolLabel = document.createElement('label');
  rolLabel.setAttribute('for', 'role-to-select');
  rolLabel.innerText = 'Rol';
  form.appendChild(rolLabel);
  let rol = document.createElement('select');
  rol.id = 'select-rol';
  rol.name = 'rol';
  form.appendChild(rol);

  let rolPromise = selectAllRoles();
  rolPromise.then(() => {
  }).catch(() => {
    console.log('ERROR CON PERMISOS');
  })

  let permisoLabel = document.createElement('label');
  permisoLabel.setAttribute('for', 'permiso-to-select');
  permisoLabel.innerText = 'Permiso';
  form.appendChild(permisoLabel);
  let permiso = document.createElement('select');
  permiso.id = 'select-permiso';
  permiso.name = 'permiso';
  form.appendChild(permiso);

  let permisoPromise = selectAllPermissions();
  permisoPromise.then(() => {
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

    let rol = document.getElementById('select-rol').value,
      permiso = document.getElementById('select-permiso').value;

    let peticion = new XMLHttpRequest()
    let params = `option=associate&rol=${rol}&permiso=${permiso}`;
    console.log(params);
    peticion.open('GET', `./consult_roles.php?${params}`)

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
        getRoles();
      }
    }
  })
}

function selectAllRoles() {
  return new Promise((resolve, reject) => {
    let peticion = new XMLHttpRequest()
    let params = `option=all-roles`   //PARTE DE LA URL QUE DEFINE LOS ELEMENTOS DE GET
    peticion.open('GET', `./consult_roles.php?${params}`)

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
        let dropRoles = document.getElementById('select-rol');
        removeAllChilds(dropRoles);
        for(d in data){
          let op = document.createElement('option');
          op.value = data[d].id;
          op.innerText = data[d].rol;
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

function selectAllPermissions() {
  return new Promise((resolve, reject) => {
    let peticion = new XMLHttpRequest()
    let params = `option=all-permisos`   //PARTE DE LA URL QUE DEFINE LOS ELEMENTOS DE GET
    peticion.open('GET', `./consult_roles.php?${params}`)

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
        let dropPermisos = document.getElementById('select-permiso');
        removeAllChilds(dropPermisos);
        for(d in data){
          let op = document.createElement('option');
          op.value = data[d].id;
          op.innerText = data[d].permiso;
          dropPermisos.appendChild(op);
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
function setChangePosibilityRoles(){
  let rows = document.getElementsByTagName('tr');
  for (let i = 0; i < rows.length; i++){
    let element = rows[i];
    if (element.id !== 'table-head'){
      element.addEventListener('click', function (event) {
        if(event.target.classList.contains('clickeable-roles')) {
          let columns = event.target.parentElement.children;
          for (let j = 0; j < columns.length - 1; j++) {
            let input = document.createElement('input');
            input.type = 'text';
            input.name = `rol-input`;
            input.value = columns[j].innerText;
            columns[j].innerText = '';
            if(columns[j].id){
              input.id = columns[j].id;
            }
            columns[j].appendChild(input);
          }
          document.getElementById('delete-btn-roles').classList.remove('disabled');
          document.getElementById('submit-btn-roles').classList.remove('disabled');
        }
      })
    }
  }
}

document.getElementById('roles').addEventListener('click', function (event){
  document.getElementById('title').innerText = 'Roles';

  if(dataT){
    dataT.destroy();
  }

  document.getElementById('table_id').classList.remove('d-none');
  if(document.getElementById('addTuple')) {
    document.getElementById('addTuple').remove();
  }

  let addBtn = document.getElementsByClassName('add-btn')[0];
  addBtn.classList.remove('disabled');
  addBtn.id='add-btn-roles';
  document.getElementById('add-btn-roles').addEventListener('click', setAddRoles);
  let deleteBtn = document.getElementsByClassName('delete-btn')[0];
  deleteBtn.classList.add('disabled');
  deleteBtn.id='delete-btn-roles';
  document.getElementById('delete-btn-roles').addEventListener('click', setDeleteRoles);
  let submitBtn = document.getElementsByClassName('submit-btn')[0];
  submitBtn.classList.add('disabled');
  submitBtn.id='submit-btn-roles';
  document.getElementById('submit-btn-roles').addEventListener('click', setUpdateRoles);
  getRoles();
});

function setAddRoles(){
  console.log('añadir roles coño');
  let tableDiv = document.getElementById('table_id');
  //dataT.destroy();
  removeAllChilds(tableDiv);
  tableDiv.classList.add('d-none');

  let form = document.createElement('form');
  form.id = 'addTuple';

  let roleLabel = document.createElement('label');
  roleLabel.setAttribute('for', 'role');
  roleLabel.innerText = 'Nombre de Rol';
  form.appendChild(roleLabel);

  let rol = document.createElement('input');
  rol.type = 'text';
  rol.id='role-name';
  rol.name = 'role-name';
  form.appendChild(rol);

  let submit = document.createElement('button');
  submit.id = 'submit-change-role';
  submit.classList.add('btn', 'btn-primary');
  submit.innerText='Agregar Rol';
  form.appendChild(submit);
  document.getElementById('container').appendChild(form);

  submit.addEventListener('click', function () {

    let rol = document.getElementById('role-name').value;

    let peticion = new XMLHttpRequest()
    let params = `option=create&rol=${rol}`;
    console.log(params);
    peticion.open('GET', `./consult_roles.php?${params}`)

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
        getRoles();
      }
    }
  })
}

function setUpdateRoles(){
  let id_rol = document.getElementsByName('rol-input')[0].id,
      rol = document.getElementsByName('rol-input')[0].value;

  id_rol = returnIdNumber(id_rol);

  let peticion = new XMLHttpRequest()
  let params = `option=update&id_rol=${id_rol}&rol=${rol}`;   //PARTE DE LA URL QUE DEFINE LOS ELEMENTOS DE GET
  console.log(params);
  peticion.open('GET', `./consult_roles.php?${params}`)

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
      getRoles();
    }
  }
}

//FUNCION PARA ELIMINAR UNA NOTARIA
function setDeleteRoles(){
  let rol = document.getElementsByName('rol-input')[0].id

  rol = returnIdNumber(rol);

  let peticion = new XMLHttpRequest()
  let params = `option=delete&id_rol=${rol}`;   //PARTE DE LA URL QUE DEFINE LOS ELEMENTOS DE GET
  console.log(params);
  peticion.open('GET', `./consult_roles.php?${params}`)

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
      getRoles();
    }
  }
}
