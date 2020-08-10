
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

document.getElementById('posts').addEventListener('click', function (event){
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
  let deleteBtn = document.getElementsByClassName('delete-btn')[0];
  deleteBtn.classList.add('disabled');
  deleteBtn.id='delete-btn-posts';
  let submitBtn = document.getElementsByClassName('submit-btn')[0];
  submitBtn.classList.add('disabled');
  submitBtn.id='submit-btn-posts';

  getPosts();
});

function getPosts() {

  let peticion = new XMLHttpRequest()
  let params = `option=select`   //PARTE DE LA URL QUE DEFINE LOS ELEMENTOS DE GET
  peticion.open('GET', `./consult_posts.php?${params}`)

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
    let imagen = document.createElement('td')
    imagen.innerText = 'Imagen';
    let seccion = document.createElement('td')
    seccion.innerText = 'Sección';
    let titulo = document.createElement('td')
    titulo.innerText = 'Título';
    let cuerpo = document.createElement('td')
    cuerpo.innerText = 'Cuerpo';
    tr1.appendChild(imagen);
    tr1.appendChild(seccion);
    tr1.appendChild(titulo);
    tr1.appendChild(cuerpo);
    thead.appendChild(tr1);
    let tbody = document.createElement('tbody');
    if(!data.error){
      for(d in data) {
        let tr2 = document.createElement('tr');
        tr2.id = data[d].id;
        tr2.classList.add('clickeable-posts');

        let imagenCol = document.createElement('td')
        imagenCol.classList.add('clickeable-posts');

        let imagenC2 = document.createElement('img');
        imagenC2.src = `../img/${data[d].ruta}`
        imagenC2.id = `imagen-${data[d].id_imagen}`;
        imagenC2.height = 75;
        imagenC2.classList.add('clickeable-posts');

        let seccionC2 = document.createElement('td')
        seccionC2.innerText = data[d].seccion;
        seccionC2.classList.add('clickeable-posts');

        let tituloC2 = document.createElement('td')
        tituloC2.innerText = data[d].titulo;
        tituloC2.classList.add('clickeable-posts');

        let cuerpoC2 = document.createElement('td')
        cuerpoC2.innerText = data[d].cuerpo;
        cuerpoC2.classList.add('clickeable-posts');

        tr2.appendChild(imagenCol);
        imagenCol.appendChild(imagenC2);
        tr2.appendChild(seccionC2);
        tr2.appendChild(tituloC2);
        tr2.appendChild(cuerpoC2);
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
    setChangePosibilityPosts();
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
          let names = ['imagen','seccion','titulo','cuerpo'];
          for (let j = 0; j < columns.length; j++) {
            if (j === 0) {
              let input = document.createElement('input');
              input.type = 'file';
              input.name = names[j];
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
  dataT.destroy();
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
      //getClients();
    }
  }
}
