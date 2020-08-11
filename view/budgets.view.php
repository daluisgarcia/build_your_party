<?php
    require 'navbar.php'
?>
<br>
<br>

<div class="container my-2">
    <div class="display-3 my-2">Fiesta: <?php echo $party_info['nombre'].' '.$party_info['fecha']; ?></div>
    <?php for($i = 0; $i < sizeof($budgets); $i++): ?>
        <div class="card my-1" style="width: 100%">
            <div class="card-body">
                <h5 class="card-title h2">Presupuesto <?php echo $budgets[$i]['fecha']; ?></h5>
                <p class="card-text"><b>Total: </b><?php echo get_total_price($budget_details[$i]); ?></p>
                <p id="toggler-<?php echo $budgets[$i]['id']; ?>" class="border-top">
                    <?php foreach ($budget_details[$i] as $det): ?>
                    <p>
                        <?php if($det[0]['id_servicio'] === null): ?>
                            <!--PRODUCTO-->
                            <div class="row pb-3">
                                <div class="col">
                                    <span class="mx-1 h4">
                                        <?php echo $det[0]['nombre_producto'] ?>
                                    </span>
                                </div>
                                <div class="col text-right">
                                    <span class="mx-1"><?php echo $det[0]['precio_producto']; ?></span>
                                    <span>*</span>
                                    <span class="mx-1"><?php echo $det[0]['cantidad_producto']; ?></span>
                                    <span>=</span>
                                </div>
                                <div class="col-2 text-right">
                                    <span class="mx-1"><?php echo $det[0]['precio_total']; ?></span>
                                </div>
                            </div>
                        <?php elseif($det[0]['id_producto'] === null): ?>
                            <!--SERVICIO-->
                            <div class="row pb-3">
                                <div class="col">
                                    <div class="mx-1 h4">
                                        <?php echo $det[0]['nombre_servicio'] ?>
                                    </div>
                                    <div class="mx-1">
                                        Modalidad: <?php echo $det[0]['modalidad'] ?>
                                    </div>
                                </div>
                                <div class="col text-right">
                                    <span class="mx-1"><?php echo $det[0]['precio_servicio']; ?></span>
                                    <span>*</span>
                                    <span class="mx-1"><?php echo $det[0]['cantidad_horas']; ?></span>
                                    <span>=</span>
                                </div>
                                <div class="col-2 text-right">
                                    <span class="mx-1"><?php echo $det[0]['precio_total']; ?></span>
                                </div>
                            </div>
                        <?php else: ?>
                            <!--SERVICIO CON PRODUCTOS-->
                            <div class="row pb-2">
                                <div class="col">
                                    <div class="mx-1 h4">
                                        <?php echo $det[0]['nombre_servicio'] ?>
                                    </div>
                                    <div class="mx-1">
                                        Modalidad: <?php echo $det[0]['modalidad'] ?>
                                    </div>
                                </div>
                                <div class="col text-right">
                                    <span class="mx-1"><?php echo $det[0]['precio_servicio']; ?></span>
                                    <span>*</span>
                                    <span class="mx-1"><?php echo $det[0]['cantidad_horas']; ?></span>
                                    <span>=</span>
                                </div>
                                <div class="col-2 text-right">
                                    <span class="mx-1"><?php echo $det[0]['precio_servicio']; ?></span>
                                </div>
                            </div>
                            <div class="pb-1">
                                <?php foreach ($det as $d): ?>
                                    <div class="row pb-2">
                                        <div class="col-1"></div>
                                        <div class="col"><span class="mx-1 h4"><?php echo $d['nombre_producto']; ?></span></div>
                                        <div class="col text-right">
                                            <span class="mx-1"><?php echo $d['precio_producto']; ?></span>
                                            <span>*</span>
                                            <span class="mx-1"><?php echo $d['cantidad_producto']; ?></span>
                                            <span>=</span>
                                        </div>
                                        <div class="col-2 text-right">
                                            <span class="mx-1"><?php echo intval($d['precio_producto'])*intval($d['cantidad_producto']); ?></span>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <div class="row pb-3">
                                <div class="col text-right">
                                    <span class="mx-1">Total</span>
                                    <span>=</span>
                                </div>
                                <div class="col-2 text-right">
                                    <span class="mx-1"><?php echo $det[0]['precio_total']; ?></span>
                                </div>
                            </div>
                        <?php endif ?>
                    </p>
                    <?php endforeach ?>
                </p>
                <button type="button" class="btn btn-primary mx-1 toggler" data-toggle="toggler-<?php echo $budgets[$i]['id']; ?>">Mostrar detalle</button>
                <a href="contracts?idBudget=<?php echo $budgets[$i]['id']; ?>" class="btn btn-success mx-1">Procesar presupuesto</a>
            </div>
        </div>
    <?php endfor ?>
</div>

<script>
    var togglers = document.getElementsByClassName('toggler');
    for (let i = 0; i < togglers.length; i++)  {
        togglers[i].addEventListener('click', function (event) {
            
        })
    }
</script>

</body>
</html>