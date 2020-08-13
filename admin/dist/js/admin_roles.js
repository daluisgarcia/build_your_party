
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

function selectPermisos(rol) {
  return new Promise((resolve, reject) => {
    let peticion = new XMLHttpRequest()
    let params = `option=permisos&rol=${rol}`   //PARTE DE LA URL QUE DEFINE LOS ELEMENTOS DE GET
    console.log(params);
    peticion.open('GET', `../consult_roles.php?${params}`)

    peticion.send()

    //loader.classList.add('active');

    peticion.onreadystatechange = function () {
      if (peticion.readyState == 4 && peticion.status == 200) {
        //loader.classList.remove('active')
      }
    }

    peticion.onload = function () {
      console.log('la peticion al menos'+peticion.responseText);
      let data = JSON.parse(peticion.responseText)
      if(!data.error) {
        console.log('no error al menos');
        let dropPermisos = document.getElementById('permisos-select');
        removeAllChilds(dropPermisos);
        for(d in data){
          let op = document.createElement('option');
          op.value = data[d].id;
          op.innerText = data[d].nombre;
          dropEstado.appendChild(op);
          console.log(op);
        }
        resolve();
      }else{
        //alert('Error al cargar los estados');
        console.log('coño mala tuya manin');
        reject();
      }
    }
  })
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
  let deleteBtn = document.getElementsByClassName('delete-btn')[0];
  deleteBtn.classList.add('disabled');
  deleteBtn.id='delete-btn-roles';
  let submitBtn = document.getElementsByClassName('submit-btn')[0];
  submitBtn.classList.add('disabled');
  submitBtn.id='submit-btn-roles';
  console.log('entra1');
  getRoles();
});

function getRoles() {
  console.log('entra');
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
    let agregar = document.createElement('td')
    agregar.innerText = 'Agregar';
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
        permisosC2.id = 'permisos-select';
        permisosC2.name = 'permisos';
        let selectedRole = returnIdNumber(data[d].id);

        let promise = selectPermisos(data[d].id);
        promise.then(() => {
          permisosC2.value = selectedRole;
        }).catch(() => {
          console.log('ERROR CON PERMISOS');
        })

        let agregarC2 = document.createElement('button')
        agregarC2.id = 'check-permisos';
        agregarC2.classList.add('btn', 'btn-primary');
        agregarC2.innerText='Agregar Permiso';

        tr2.appendChild(rolC2);
        tr2.appendChild(permisosC2);
        tr2.appendChild(agregarC2);
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
    //setChangePosibilityPosts();
  }
};

//AÑADIR A LAS FILAS LA POSIBILIDAD DE CAMBIAR LOS DATOS
function setChangePosibilityPosts(){
  let rows = document.getElementsByTagName('tr');
  for (let i = 0; i < rows.length; i++){
    let element = rows[i];
    if (element.id !== 'table-head'){
      element.addEventListener('click', function (event) {
        if(event.target.classList.contains('clickeable-posts')) {
          let columns = event.target.parentElement.children;
          let names = ['imagenR','seccion','titulo','cuerpo'];
          for (let j = 0; j < columns.length; j++) {
            if (j === 0) {
              let input = document.createElement('input');
              input.type = 'text';
              input.name = `imagenR`;
              input.value = columns[j].id;
              if(columns[j].id){
                input.id = columns[j].id;
              }
              columns[j].appendChild(input);
            }
            if ((j > 0) && (j !== 3)) {
              let input = document.createElement('input');
              input.type = 'text';
              input.name = names[j];
              input.value = columns[j].innerText;
              if(j < 2){
                input.id = element.id;
              }
              columns[j].innerText = '';
              if(columns[j].id){
                input.id = columns[j].id;
              }
              columns[j].appendChild(input);
            } else if (j === 3) {
              let textarea = document.createElement('textarea');
              textarea.name = names[j];
              textarea.classList.add('w-100');
              textarea.value = columns[j].innerText;
              if(columns[j].id){
                textarea.id = columns[j].id;
              }
              columns[j].innerText = '';
              columns[j].appendChild(textarea);
            }

          }
          document.getElementById('delete-btn-posts').classList.remove('disabled');
          document.getElementById('submit-btn-posts').classList.remove('disabled');
        }
      })
    }
  }
}

document.getElementById('posts').addEventListener("click", function (event) {
  document.getElementById('title').innerText = 'Posts';

  if(dataT){
    dataT.destroy();
  }

  document.getElementById('table_id').classList.remove('d-none');
  if(document.getElementById('addTuple')) {
    document.getElementById('addTuple').remove();
  }

  let addBtn = document.getElementsByClassName('add-btn')[0];
  addBtn.classList.remove('disabled');
  addBtn.id='add-btn-posts';
  document.getElementById('add-btn-posts').addEventListener('click', setAddPosts);
  let deleteBtn = document.getElementsByClassName('delete-btn')[0];
  deleteBtn.classList.add('disabled');
  deleteBtn.id='delete-btn-posts';
  document.getElementById('delete-btn-posts').addEventListener('click', setDeletePosts);
  let submitBtn = document.getElementsByClassName('submit-btn')[0];
  submitBtn.classList.add('disabled');
  submitBtn.id='submit-btn-posts';
  document.getElementById('submit-btn-posts').addEventListener('click', setUpdatePosts);
  getPosts();
});

//FUNCION PARA CREACION DE FORMULARIO Y AGREGAR UN CLIENTE
function setAddPosts(){
  let tableDiv = document.getElementById('table_id');
  dataT.destroy();
  removeAllChilds(tableDiv);
  tableDiv.classList.add('d-none');

  let form = document.createElement('form');
  form.id = 'addTuple';

  let imagenLabel = document.createElement('label');
  imagenLabel.setAttribute('for', 'imagen');
  imagenLabel.innerText = 'Imagen';
  form.appendChild(imagenLabel);

  let imagen = document.createElement('input');
  imagen.type = 'text';
  imagen.id='imagen-post';
  imagen.name = 'imagen-post';
  form.appendChild(imagen);

  let seccionLabel = document.createElement('label');
  seccionLabel.setAttribute('for', 'seccion-post');
  seccionLabel.innerText = 'Seccion';
  form.appendChild(seccionLabel);

  let seccion = document.createElement('input');
  seccion.id='seccion-post';
  seccion.name = 'seccion-post';
  form.appendChild(seccion);

  let tituloLabel = document.createElement('label');
  tituloLabel.setAttribute('for', 'titulo-post');
  tituloLabel.innerText = 'Titulo post';
  form.appendChild(tituloLabel);

  let titulo = document.createElement('input');
  titulo.id='titulo-post';
  titulo.name = 'titulo-post';
  form.appendChild(titulo);

  let cuerpoLabel = document.createElement('label');
  cuerpoLabel.setAttribute('for', 'cuerpo-post');
  cuerpoLabel.innerText = 'Cuerpo post';
  form.appendChild(cuerpoLabel);

  let cuerpo = document.createElement('textarea');
  cuerpo.id = 'cuerpo-post';
  cuerpo.name = 'cuerpo-post';
  cuerpo.classList.add('w-100');
  form.appendChild(cuerpo);

  let submit = document.createElement('button');
  submit.id = 'submit-change-post';
  submit.classList.add('btn', 'btn-primary');
  submit.innerText='Agregar Post';
  form.appendChild(submit);
  document.getElementById('container').appendChild(form);

  submit.addEventListener('click', function () {

    let imagen = document.getElementById('imagen-post').value,
      seccion = document.getElementById('seccion-post').value,
      titulo = document.getElementById('titulo-post').value,
      cuerpo = document.getElementById('cuerpo-post').value;

    let peticion = new XMLHttpRequest()
    let params = `option=create&seccion=${seccion}&titulo=${titulo}&cuerpo=${cuerpo}&ruta=${imagen}`;
    console.log(params);
    peticion.open('GET', `./consult_posts.php?${params}`)

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
        getPosts();
      }
    }
  })
}

//FUNCION PARA HACER UPDATE DE UNA NOTARIA
function setUpdatePosts(){
  let seccion = document.getElementsByName('seccion')[0].value,
    postID = document.getElementsByName('seccion')[0].id,
    titulo = document.getElementsByName('titulo')[0].value,
    cuerpo = document.getElementsByName('cuerpo')[0].value,
    imagenID = document.getElementsByName('imagen')[0].id,
    ruta = document.getElementsByName('imagenR')[0].value;

  postID = returnIdNumber(postID);
  imagenID = returnIdNumber(imagenID);

  let peticion = new XMLHttpRequest()
  let params = `option=update&id_post=${postID}&seccion=${seccion}&titulo=${titulo}&cuerpo=${cuerpo}&id_imagen=${imagenID}&ruta=${ruta}`;   //PARTE DE LA URL QUE DEFINE LOS ELEMENTOS DE GET
  console.log(params);
  peticion.open('GET', `./consult_posts.php?${params}`)

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
      getPosts();
    }
  }
}

//FUNCION PARA ELIMINAR UNA NOTARIA
function setDeletePosts(){
  let post = document.getElementsByName("seccion")[0].id

  let peticion = new XMLHttpRequest()
  let params = `option=delete&id_post=${post}`;   //PARTE DE LA URL QUE DEFINE LOS ELEMENTOS DE GET
  peticion.open('GET', `./consult_posts.php?${params}`)

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
      getPosts();
    }
  }
}
