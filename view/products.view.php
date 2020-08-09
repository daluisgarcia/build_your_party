
<br>
<br>

<div class="container-fluid mt-3">
    <div class="row">
        <section class="col-2 border-right">
            <div class="h4">
                Categorias
            </div>
            <div id="c-categorias">
                <?php print_list($categories); ?>
            </div>
        </section>
        <section class="col-10" id="c-productos">
            <div class="display-3 mb-2" id="products-title">Todos los productos</div>
            <div class="form-group form-inline mx-auto my-3">
                <label for="party-select" class="m-1 ml-2">Seleccione la fiesta</label>
                <select id="party-select" class="form-control" onchange="selectBudgets()">
                    <!-- CARGAR AQUI LISTA DE FIESTAS-->
                </select>
                <a href="party_select" id="add-party-btn" class="btn btn-primary ml-2">Añadir fiesta</a>
                <label for="budget-select" class="m-1 ml-2">Seleccione el presupuesto</label>
                <select id="budget-select" class="form-control" >
                    <!-- CARGAR AQUI LISTA DE PRESUPUESTOS POR FIESTAS-->
                </select>
                <button type="button" id="add-budget-btn" class="btn btn-primary ml-2">Añadir nuevo presupuesto</button>
            </div>
            <div id="productos-row" class="row">
                <?php foreach ($products as $p): ?>
                    <?php if ($p['CLASE']==='SERVICIO'): ?>
                        <div class="col-4">
                            <div href="SERVICIO-<?php echo $p['id']; ?>" class="text-decoration-none card hover-shadow can-buy">
                                <img src="<?php echo IMG_FOLDER.$p['imagen']; ?>" class="card-img-top" alt="..." height="200px">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $p['nombre']; ?> <i>SERVICIO</i></h5>
                                    <p class="card-text"><b>Precio:</b> <?php echo $p['precio']; ?></p>
                                    <p class="card-text"><b>Modalidad de pago:</b> <?php echo $p['modalidad_pago']; ?></p>
                                    <p class="card-text"><?php echo $p['detalles']; ?></p>
                                    <p class="card-text">
                                        Selecciona la cantidad/horas:
                                        <input class="form-inline" type="number" value="40" min="40" max="1000" step="1"/>
                                    </p>
                                    <button type="button" class="btn btn-outline-primary">Agregar a presupuesto</button>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="col-4">
                            <div class="text-decoration-none card hover-shadow can-buy">
                                <img src="<?php echo IMG_FOLDER.$p['imagen']; ?>" class="card-img-top" alt="..." height="200px">
                                <div class="card-body" id="PRODUCTO-<?php echo $p['id']; ?>">
                                    <h5 class="card-title"><?php echo $p['nombre'] ?> <i>PRODUCTO</i></h5>
                                    <p class="card-text"><b>Precio:</b> <?php echo $p['precio']; ?></p>
                                    <p class="card-text">
                                        Selecione la cantidad:
                                        <input class="form-inline" type="number" value="1" min="1" max="1000" step="1"/>
                                    </p>
                                    <button type="button" class="btn btn-outline-primary">Agregar a presupuesto</button>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </section>
    </div>
</div>

<script onload="selectPartys()" src="js/products_AJAX.js"></script>

</body>
</html>

