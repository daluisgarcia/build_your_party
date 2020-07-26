const IMG_FOLDER = 'img/';

function validate(search, category, feature){
    if (search === ''){
        return false
    }else if(category === ''){
        return false
    }else if(feature === ''){
        return false
    }
    return true
}

function sanitize(string){
    let element = document.createElement('div')
    element.innerHTML = string
    return element.innerText.trim()   //Limpia el texto y evita insersion de codigo html
}

function removeAllChilds(element) {
    let child = element.lastChild;
    while(child){
        element.removeChild(child);
        child = element.lastChild;
    }
}

function showContent(data){
    let col3 = document.createElement('div');
    if(data.CLASE === 'SERVICIO'){
        col3.classList.add('col-3');
            let a = document.createElement('a');
            a.classList.add('text-decoration-none', 'card');
            a.href = `SERVICIO-${data.id}`;
                let img = document.createElement('img');
                img.classList.add('card-img-top');
                let body = document.createElement('div');
                body.classList.add('card-body');
                    let title = document.createElement('h5');
                    title.classList.add('card-title');
                    title.innerHTML = `${data.nombre} <i>SERVICIO</i>`;
                    let p1 = document.createElement('p');
                    p1.classList.add('card-text');
                    p1.innerHTML = `<b>Precio</b> ${data.precio}`;
                    let p2 = document.createElement('p');
                    p2.classList.add('card-text');
                    p2.innerHTML = `<b>Modalidad de pago:</b> ${data.modalidad_pago}`;
                    let p3 = document.createElement('p');
                    p3.classList.add('card-text');
                    p3.innerHTML = `${data.detalles}`;
                body.appendChild(title);
                body.appendChild(p1);
                body.appendChild(p2);
                body.appendChild(p3);
            a.appendChild(img);
            a.appendChild(body);
        col3.appendChild(a);
    }else{
        col3.classList.add('col-3');
            let a = document.createElement('a');
            a.classList.add('text-decoration-none', 'card');
            a.href = `SERVICIO-${data.id}`;
                let img = document.createElement('img');
                img.classList.add('card-img-top');
                let body = document.createElement('div');
                body.classList.add('card-body');
                    let title = document.createElement('h5');
                    title.classList.add('card-title');
                    title.innerHTML = `${data.nombre} <i>PRODUCTO</i>`;
                    let p1 = document.createElement('p');
                    p1.classList.add('card-text');
                    p1.innerHTML = `<b>Precio</b> ${data.precio}`;
                body.appendChild(title);
                body.appendChild(p1);
            a.appendChild(img);
            a.appendChild(body);
        col3.appendChild(a);
    }

    return col3;
}

//var loader;

var categories = document.getElementsByClassName('category');
for (let i = 0; i < categories.length; i++) {
    categories[i].addEventListener('click', function (event) {

        event.preventDefault() //IMPIDE QUE SE ENVIE EN FORMULARIO AUTOMATICAMENTE

        //QUITA EL MENSAJE DE 'NO SE HAN ENCONTRADO RESULTADOS'
        removeAllChilds(document.getElementById('productos-row'))

        let idCat = event.target.id;

        let peticion = new XMLHttpRequest()
        let params = `category=${idCat}`   //PARTE DE LA URL QUE DEFINE LOS ELEMENTOS DE GET
        peticion.open('GET', `./product_search.php?${params}`)

        peticion.send()

        //loader.classList.add('active');

        peticion.onreadystatechange = function () {
            if (peticion.readyState == 4 && peticion.status == 200) {
                //loader.classList.remove('active')
            }
        }

        peticion.onload = function () {
            let data = JSON.parse(peticion.responseText)
            console.log(data)
            let container = document.getElementById('productos-row');
            removeAllChilds(container);
            if (data.error) {
                let element = document.createElement('p')
                element.innerText = data.error
                document.getElementById('productos-row').appendChild(element)
            } else {
                console.log(data.length);
                for (let i = 0; i < data.length; i++) {
                    container.appendChild(showContent(data[i]))
                }
            }
        }

    });
}