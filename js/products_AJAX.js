const IMG_FOLDER = 'img/';

function returnIdNumber(id) {
    let index = id.indexOf('-')+1;
    return id.substr(index, id.length-index);
}

function returnCode(id) {
    let index = id.indexOf('-');
    return id.substr(0, index);
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
    let params = `option=getPartys`;
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
                document.getElementById('goToBudgets').href = `budgets?idParty=${data[d].id}`;
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
    let params = `idfiesta=${partyId}&option=getBudgets`;
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

document.getElementById('add-budget-btn').addEventListener('click', function (event) {
    let peticion = new XMLHttpRequest();
    let partyId = document.getElementById('party-select');
    let index = partyId.selectedIndex;
    partyId = partyId[index].value;
    let params = `idfiesta=${partyId}&option=addBudget`;
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
        }else{
            //ACTUALIZAR DROPDOWN DE PRESUPUESTOS
            selectBudgets();
        }
    }
})

function addToBudget(btn){
    //PRIMERO SE INICIALIZA LA TUPLA EN PRODUCTO_PRESUPUESTO, LUEGO SE INTRODUCE CADA PRODUCTO CON SU CANTIDADD CON EL CODIGO DE ESA TUPLA EN LA ENTIDAD PUENTE
    let budget = document.getElementById('budget-select');
    let index = budget.selectedIndex;
    //SE VALIDA SI EXISTE ALGUN ELEMENTO SELECCIONADO EN EL DROPDOWN DE PRESUPUESTOS
    if(index === -1){
        alert('ERROR: Debe agregar y seleccionar un presupuesto para poder agregar servicio a él.')
    }else{
        //EN CASO DE QUE EXISTA SE TOMA EL VALOR DE LA SELECCION
        budget = budget[index].value;
        //SE TOMA EL CODIGO Y ID DEL OBJETO A AGREGAR AL PRESUPUESTO
        let code = returnCode(btn.name);
        let ID = returnIdNumber(btn.name);

        let peticion = new XMLHttpRequest();
        let params='';
        let container = document.getElementById(btn.name);
        if (code === 'PRODUCTO'){
            let quantity = container.getElementsByClassName('QUANTP')[0].value;
            let price = container.getElementsByClassName('PRECIO')[0].innerText;

            params = `option=addProductNoService&idbudget=${budget}&productprice=${price}&productquantity=${quantity}&productid=${ID}`;

        }else if (code === 'SERVICIO'){
            let modal = container.getElementsByClassName('MODALIDAD')[0].innerText;
            if (modal === 'CANTIDAD'){
                //PRIMERO CREAR EL SERVICIO_PRESUPUESTO Y LUEGO AGREGAR TODOS LOS PRODUCTOS
                let prices = container.getElementsByClassName('PRECIO');
                let quantities = container.getElementsByClassName('QUANTP');
                let servicePrice = prices[0].innerText;
                let totalPrice = 0;
                for (let i=1; i<prices.length; i++){
                    totalPrice += parseFloat(prices[i].innerText)*parseFloat(quantities[i-1].value);;
                }
                let id_reg = 0;
                params = `option=addService&serviceprice=${servicePrice}&productprice=${totalPrice}&idbudget=${budget}&serviceid=${ID}`;
                let promise = new Promise((resolve, reject) => {
                    let peticion2 = new XMLHttpRequest();
                    peticion2.open('GET', `./getPartysAndBudget.php?${params}`);
                    peticion2.send()
                    //loader.classList.add('active');
                    peticion2.onreadystatechange = function () {
                        if (peticion2.readyState == 4 && peticion2.status == 200) {
                            //loader.classList.remove('active')
                        }
                    }
                    peticion2.onload = function () {
                        let data = JSON.parse(peticion2.responseText)
                        if (data.error) {
                            reject();
                        }else{
                            id_reg = data;
                            resolve();
                        }
                    }
                })
                promise.then(()=>{
                    for (let i=1; i<prices.length; i++){
                        let quantity = parseFloat(quantities[i-1].value);
                        let productId = returnIdNumber(quantities[i-1].id);
                        let peticion2 = new XMLHttpRequest();
                        params = `option=addServicesProduct&regid=${id_reg}&productid=${productId}&productquantity=${quantity}`;
                        peticion2.open('GET', `./getPartysAndBudget.php?${params}`)
                        peticion2.send()
                        //loader.classList.add('active');
                        peticion2.onreadystatechange = function () {
                            if (peticion2.readyState == 4 && peticion2.status == 200) {
                                //loader.classList.remove('active')
                            }
                        }
                        peticion2.onload = function () {
                            let data = JSON.parse(peticion2.responseText)
                            if (data.error) {
                                alert('ERROR al agregar producto');
                                return;
                            }
                        }
                    }
                }).catch(()=>{
                    alert('ERROR al agregar producto');
                    return;
                })
                params = ``;
            }else if(modal === 'HORA'){

                let quantity = container.getElementsByClassName('QUANTH')[0].value;
                let price = container.getElementsByClassName('PRECIO')[0].innerText;
                params = `option=addServiceByHour&idbudget=${budget}&serviceprice=${price}&servicehours=${quantity}&serviceid=${ID}`;

            }else if(modal === 'NA'){
                let quantity = 1
                let price = container.getElementsByClassName('PRECIO')[0].innerText;
                params = `option=addServiceByHour&idbudget=${budget}&serviceprice=${price}&servicehours=${quantity}&serviceid=${ID}`;
            }
        }
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
                alert('ERROR al agregar producto');
            }else{
                alert('Agregado exitosamente');
            }
        }
    }
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
                    p1.innerHTML = `<b>Precio:</b> <span class="PRECIO">${data.precio}</span>`;
                    let p2 = document.createElement('p');
                    p2.classList.add('card-text');
                    p2.innerHTML = `<b>Modalidad de pago:</b><span class="MODALIDAD">${data.modalidad_pago}</span>`;
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
                                label.innerHTML = `<b>Precio por unidad de ${prod[i].nombre_producto}:</b> <span class="PRECIO">${prod[i].precio_producto}</span>`;
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
                                input.classList.add('form-inline', 'QUANTP');
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
                        input.classList.add('form-inline', `QUANTH`);
                        p11.innerText='Selecciona la cantidad de horas:';
                        p11.appendChild(input);
                        body.appendChild(p11);
                        body.appendChild(p3);
                        body.appendChild(btn);
                    }else if(data.modalidad_pago === 'NA'){
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
                    p1.innerHTML = `<b>Precio</b> <span class="PRECIO">${data.precio}</span>`;
                    let p11 = document.createElement('p');
                    p11.classList.add('card-text');
                    let input = document.createElement('input');
                    input.type='number';
                    input.min = 1;
                    input.value = input.min;
                    input.max = 100;
                    input.step = 1;
                    input.classList.add('form-inline', `QUANTP`);
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