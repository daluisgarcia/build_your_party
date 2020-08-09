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

function getProduct(id){
    return new Promise((resolve, reject) => {
        let peticion = new XMLHttpRequest()
        let params = `serviceid=${id}`   //PARTE DE LA URL QUE DEFINE LOS ELEMENTOS DE GET
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
            if (data.error) {
                alert('ERROR: Recoleccion de productos para servicios fallida')
                reject();
            } else {
                resolve(data);
            }
        }
    })
}

function selectPartys() {
    let peticion = new XMLHttpRequest()
    let params = ``;
    peticion.open('GET', `./getPartysAndBudget.php?${params}`)

    peticion.send()

    //loader.classList.add('active');

    peticion.onreadystatechange = function () {
        if (peticion.readyState == 4 && peticion.status == 200) {
            //loader.classList.remove('active')
        }
    }

    peticion.onload = function () {
        let data = JSON.parse(peticion.responseText)
        if (data.error) {
            alert('ERROR: Recoleccion de fiestas')
        } else {
            //LLENAR DROPDOWN DE FIESTAS
            let dropdown = document.getElementById('party-select');
            removeAllChilds(dropdown);
            for(d in data){
                let opt = document.createElement('option');
                opt.value = data[d].id;
                opt.innerText = data[d].fecha;
                dropdown.appendChild(opt);
            }
            selectBudgets();
        }
    }
}

function selectBudgets() {
    let peticion = new XMLHttpRequest();
    let partyId = document.getElementById('party-select');
    let index = partyId.selectedIndex;
    partyId = partyId[index].value;
    let params = `idfiesta=${partyId}`;
    peticion.open('GET', `./getPartysAndBudget.php?${params}`)

    peticion.send()

    //loader.classList.add('active');

    peticion.onreadystatechange = function () {
        if (peticion.readyState == 4 && peticion.status == 200) {
            //loader.classList.remove('active')
        }
    }

    peticion.onload = function () {
        let data = JSON.parse(peticion.responseText)
        if (data.error) {
            alert('ERROR: Recoleccion de fiestas');
        } else if (data.length === 0){
            alert('Debe crear un presupuesto para poder agregar productos');
        }else{
            //LLENAR DROPDOWN DE PRESUPUESTOS
            let dropdown = document.getElementById('budget-select');
            removeAllChilds(dropdown);
            for(d in data){
                let opt = document.createElement('option');
                opt.value = data[d].id;
                opt.innerText = data[d].fecha;
                dropdown.appendChild(opt);
            }
        }
    }
}

function addToBudget(btn){
    //AQUI VA EL PROCEDIMIENTO PARA AGREGAR PRODUCTOS A PRESUPUESTO
    //(VALIDAR QUE EXISTA ALGUNA FIESTA Y ALGUN PRESUPUESTO SELECCIONADO EN LOS DROPDOWN)
    alert('Agregado a presupuesto');
    console.log(btn);
}

function showContent(data){
    let col4 = document.createElement('div');
    if(data.CLASE === 'SERVICIO'){
        col4.classList.add('col-4');
            let div = document.createElement('div');
            div.classList.add('text-decoration-none', 'card', 'can-buy', 'hover-shadow');
                let img = document.createElement('img');
                img.classList.add('card-img-top');
                img.src = IMG_FOLDER+data.imagen;
                img.height = 200;
                let body = document.createElement('div');
                body.classList.add('card-body');
                body.id = `SERVICIO-${data.id}`;
                    let title = document.createElement('h5');
                    title.classList.add('card-title');
                    title.innerHTML = `${data.nombre} <i>SERVICIO</i>`;
                    let p1 = document.createElement('p');
                    p1.classList.add('card-text');
                    p1.innerHTML = `<b>Precio:</b> ${data.precio}`;
                    p1.name = 'PRECIO';
                    let p2 = document.createElement('p');
                    p2.classList.add('card-text');
                    p2.innerHTML = `<b>Modalidad de pago:</b> ${data.modalidad_pago}`;
                    p2.name = 'MODALIDAD';
                    body.appendChild(title);
                    body.appendChild(p1);
                    body.appendChild(p2);
                    let p3 = document.createElement('p');
                    p3.classList.add('card-text');
                    p3.innerHTML = `${data.detalles}`;
                    let btn = document.createElement('button');
                    btn.classList.add('btn', 'btn-outline-primary', 'btn-add-pres');
                    btn.innerText = 'Agregar a presupuesto';
                    btn.name=body.id;
                    let label = null;
                    let p11 = null;
                    if(data.modalidad_pago === 'CANTIDAD') {
                        let products = getProduct(data.id);
                        products.then((prod)=>{
                            for (let i=0; i<prod.length; i++){
                                label = document.createElement('p');
                                label.classList.add('card-text');
                                label.innerHTML = `<b>Precio por unidad de ${prod[i].nombre_producto}:</b> ${prod[i].precio_producto}`;
                                body.appendChild(label);
                                p11 = document.createElement('p');
                                p11.classList.add('card-text');
                                let input = document.createElement('input');
                                input.type='number';
                                input.min = parseInt(prod[i].cantidad_minima);
                                input.value = input.min;
                                input.max = 1000;
                                input.step = 1;
                                input.id =`QUANTP-${prod[i].id_producto}`;
                                input.name = 'QUANTP';
                                input.classList.add('form-inline');
                                p11.innerHTML=`<b>Selecciona la cantidad de ${prod[i].nombre_producto}: </b>`;
                                p11.appendChild(input);
                                body.appendChild(p11);
                            }
                            body.appendChild(p3);
                            body.appendChild(btn);
                        }).catch(()=>{

                        })
                    }else if(data.modalidad_pago === 'HORA'){
                        p11 = document.createElement('p');
                        p11.classList.add('card-text');
                        let input = document.createElement('input');
                        input.type='number';
                        input.min = 2;
                        input.value = input.min;
                        input.max = 1000;
                        input.step = 1;
                        input.name=`QUANTH`;
                        input.classList.add('form-inline');
                        p11.innerText='Selecciona la cantidad de horas:';
                        p11.appendChild(input);
                        body.appendChild(p11);
                        body.appendChild(p3);
                        body.appendChild(btn);
                    }
                    btn.addEventListener('click',function(event){addToBudget(event.target)});
            div.appendChild(img);
            div.appendChild(body);
        col4.appendChild(div);
    }else{
        col4.classList.add('col-4');
            let div = document.createElement('div');
            div.classList.add('text-decoration-none', 'card', 'can-buy', 'hover-shadow');
                let img = document.createElement('img');
                img.classList.add('card-img-top');
                img.src = IMG_FOLDER+data.imagen;
                img.height = 200;
                let body = document.createElement('div');
                body.classList.add('card-body');
                body.id = `PRODUCTO-${data.id}`;
                    let title = document.createElement('h5');
                    title.classList.add('card-title');
                    title.innerHTML = `${data.nombre} <i>PRODUCTO</i>`;
                    let p1 = document.createElement('p');
                    p1.classList.add('card-text');
                    p1.innerHTML = `<b>Precio</b> ${data.precio}`;
                    p1.name = 'PRECIO';
                    let p11 = document.createElement('p');
                    p11.classList.add('card-text');
                    let input = document.createElement('input');
                    input.type='number';
                    input.min = 1;
                    input.value = input.min;
                    input.max = 100;
                    input.step = 1;
                    input.name=`QUANTP`;
                    input.classList.add('form-inline');
                    p11.innerText='Selecciona la cantidad:';
                    p11.appendChild(input);
                    let btn = document.createElement('button');
                    btn.classList.add('btn', 'btn-outline-primary', 'btn-add-pres');
                    btn.innerText = 'Agregar a presupuesto';
                    btn.name=body.id;
                    btn.addEventListener('click',function(event){addToBudget(event.target)});
                body.appendChild(title);
                body.appendChild(p1);
                if(p11 !== null) {
                    body.appendChild(p11);
                }
                body.appendChild(btn);
            div.appendChild(img);
            div.appendChild(body);
        col4.appendChild(div);
    }
    return col4;
}

//var loader;

var categories = document.getElementsByClassName('category');
for (let i = 0; i < categories.length; i++) {
    categories[i].addEventListener('click', function (event) {

        event.preventDefault() //IMPIDE QUE SE ENVIE EN FORMULARIO AUTOMATICAMENTE

        //QUITA EL MENSAJE DE 'NO SE HAN ENCONTRADO RESULTADOS'
        removeAllChilds(document.getElementById('productos-row'))

        let idCat = event.target.id;

        document.getElementById('products-title').innerText=`Categoria: ${event.target.innerText}`;

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
            let container = document.getElementById('productos-row');
            removeAllChilds(container);
            if (data.error) {
                let element = document.createElement('p')
                element.innerText = data.error
                document.getElementById('productos-row').appendChild(element)
            } else {
                for (let i = 0; i < data.length; i++) {
                    container.appendChild(showContent(data[i]))
                }
            }
        }

    });
}