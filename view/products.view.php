
<br>
<br>

<div class="container-fluid mt-3">
    <div class="row">
        <section class="col-2 border-right" id="c-categorias">
            <?php print_list($categories); ?>
        </section>
        <section class="col-10" id="c-productos">
            <div class="row">
                <?php foreach ($products as $p): ?>
                    <?php if ($p['CLASE']==='SERVICIO'): ?>
                        <div class="col-3">
                            <a href="#" class="text-decoration-none card">
                                <img src="" class="card-img-top" alt="...">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $p['nombre']; ?> <i>SERVICIO</i></h5>
                                    <p class="card-text"><b>Precio:</b> <?php echo $p['precio']; ?></p>
                                    <p class="card-text"><b>Modalidad de pago:</b> <?php echo $p['modalidad_pago']; ?></p>
                                    <p class="card-text"><?php echo $p['detalles']; ?></p>

                                </div>
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="col-3">
                            <a href="#" class="text-decoration-none card">
                                <img src="" class="card-img-top" alt="...">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $p['nombre'] ?> <i>PRODUCTO</i></h5>
                                    <p class="card-text"><b>Precio:</b> <?php echo $p['precio']; ?></p>
                                </div>
                            </a>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </section>
    </div>
</div>

</body>
</html>

