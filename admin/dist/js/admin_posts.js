document.getElementById('posts').addEventListener('click', function (event) {
  //alert('Base');
  let peticion = new XMLHttpRequest()
  let params = `option=select`;   //PARTE DE LA URL QUE DEFINE LOS ELEMENTOS DE GET
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
      console.log('Error al obtener datos de la Base');
    }else{
      getPosts('post');
    }
  }
})

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

//SE LE ASIGNA A CADA OPCION DE LA BARRA VERTICAL IZQUIERA UN EVENTO PARA PODER CARGAR EL AJAX
var menuOption = document.getElementsByClassName('option');
for (let i = 0; i < menuOption.length; i++) {
  menuOption[i].addEventListener('click', function (event) {

    let op = event.target.id;
    page = op;

    document.getElementById('table_id').classList.remove('d-none');
    if(document.getElementById('addTuple')) {
      document.getElementById('addTuple').remove();
    }

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

function getPosts(op) {

  document.getElementById('title').innerText = 'Posts';

  let peticion = new XMLHttpRequest()
  let params = '';

  if(op === 'post'){
    params = `option=select`   //PARTE DE LA URL QUE DEFINE LOS ELEMENTOS DE GET
  }else{
    params = `option=`   //PARTE DE LA URL QUE DEFINE LOS ELEMENTOS DE GET
  }
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
        tr2.classList.add('clickeable');

        let imagenCol = document.createElement('td')
        imagenCol.classList.add('clickeable');

        let imagenC2 = document.createElement('img');
        imagenC2.src = `../img/${data[d].ruta}`
        imagenC2.id = `imagen-${data[d].id_imagen}`;
        imagenC2.height = 75;
        imagenC2.classList.add('clickeable');

        let seccionC2 = document.createElement('td')
        seccionC2.innerText = data[d].seccion;
        seccionC2.classList.add('clickeable');

        let tituloC2 = document.createElement('td')
        tituloC2.innerText = data[d].titulo;
        tituloC2.classList.add('clickeable');

        let cuerpoC2 = document.createElement('td')
        cuerpoC2.innerText = data[d].cuerpo;
        cuerpoC2.classList.add('clickeable');

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
    }
    datatable();
    setChangePosibility();
  }
};

//AÑADIR A LAS FILAS LA POSIBILIDAD DE CAMBIAR LOS DATOS
function setChangePosibility(){
  let rows = document.getElementsByTagName('tr');
  for (let i = 0; i < rows.length; i++){
    let element = rows[i];
    if (element.id !== 'table-head'){
      element.addEventListener('click', function (event) {
        if(event.target.classList.contains('clickeable')) {
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
          document.getElementById('delete-btn').classList.remove('disabled');
          document.getElementById('submit-btn').classList.remove('disabled');
        }
      })
    }
  }
}
