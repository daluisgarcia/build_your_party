
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
        imagenC2.setAttribute("route", `${data[d].ruta}`);
        imagenC2.setAttribute("name", `imagen`);
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
  imagen.type = 'file';
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
    let params = `option=create&seccion=${seccion}&titulo=${titulo}&cuerpo=${cuerpo}`;
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
    ruta = document.getElementsByName('imagen')[0].getAttribute("route")

  postID = returnIdNumber(postID);
  imagenID = returnIdNumber(imagenID);

  let peticion = new XMLHttpRequest()
  let params = `option=update&id_post=${postID}&seccion=${seccion}&titulo=${titulo}&cuerpo=${cuerpo}&id_imagen=${imagenID}&ruta=${ruta}`;   //PARTE DE LA URL QUE DEFINE LOS ELEMENTOS DE GET
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
