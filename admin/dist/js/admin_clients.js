document.getElementById('cliente').addEventListener('click', function (event) {
  //alert('Base');
  let peticion = new XMLHttpRequest()
  let params = `option=select&cedula=${cedula}&nombre=${nombre}&apellido=${apellido}&correo=${correo}&codigo_de_area=${codigo_de_area}&numero=${numero}&usuario=${usuario}&estado=${estado}&municipio=${municipio}&parroquia=${parroquia}`;   //PARTE DE LA URL QUE DEFINE LOS ELEMENTOS DE GET
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
      alert("satisfactorio supongo");
      //getNotaries('notaria');
    }
  }
})
