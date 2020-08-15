<?php
    require 'navbar.php';
?>

<br>
<br>
<br>

<div class="container mt-1">
    <div class="display-3 text-center mb-3">Contratos y pagos realizados</div>
    <section class="row">
        <?php foreach ($contracts as $contract): ?>
            <div class="card mb-3" style="width: 100%">
                <div class="card-body">
                    <h5 class="card-title h2">Contrato <?php echo $contract['fecha_aprobado'] ?> - Fiesta <?php echo $contract['nombre_fiesta'].' '.$contract['fecha_fiesta'] ?></h5>
                    <p class="card-text">
                        <b>Precio total:</b> <?php echo $contract['monto'] ?>
                        <span class="mx-2">Pago restante: <?php
                            try{
                                include_once 'model/PaymentSQL.php';
                                $conn = new PaymentSQL();

                                $paid =  $conn->get_sum_contract_payments($contract['id']);
                                if($paid !== null){
                                    echo $contract['monto']-$paid;
                                }else{
                                    echo $contract['monto'];
                                }
                            }catch (PDOException $e){
                                echo 'ERROR';
                            }
                            ?></span>
                        <?php if($contract['monto']-$paid !== 0): ?>
                            <span class="mx-2"><a href="procesar_pago?idContract=<?php echo $contract['id'] ?>" class="btn btn-success">Pagar</a></span>
                        <?php endif; ?>
                    </p>
                    <?php
                        try{
                            include_once 'model/PartySQL.php';
                            $connect = new PartySQL();

                            $dates = $connect->get_dates_by_contract($contract['id'] );

                        }catch (PDOException $e){
                            echo '<div>Error obteniendo citas</div>';
                        }
                    ?>
                    <?php if(isset($dates)): ?>
                        <?php foreach ($dates as $date): ?>
                            <div class="card-text row mb-3">
                                <div class="col">
                                    <b>Cita para:</b> <?php echo $date['nombre_servicio'] ?>
                                </div>
                                <div class="col">
                                    <?php echo $date['lugar'] ?> el dia <?php echo $date['fecha_reserva'] ?>
                                </div>
                                <div class="col">

                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    <div id="toggler-<?php echo $contract['id'] ?>" class="border-top border-bottom pt-2 d-none mb-3">

                            <?php
                                try {
                                    include_once 'model/PaymentSQL.php';
                                    $connect = new PaymentSQL();

                                    $payments = $connect->get_contract_payments($contract['id']);

                                }catch (PDOException $e){
                                    $answer =  ['error' => NO_CONTENT_FOUND];
                                }
                            ?>
                            <?php foreach ($payments as $payment): ?>
                                <div class="container">
                                    <p class="card-text">
                                        <div class="row">
                                            <div class="col">Pago <?php echo $payment['fecha'] ?></div>
                                            <div class="col-1">Monto:</div>
                                            <div class="col-2 text-right"><?php echo $payment['monto'] ?></div>
                                        </div>
                                    </p>
                                </div>
                            <?php endforeach; ?>
                    </div>
                    <?php if(sizeof($payments) > 0): ?>
                        <button type="button" class="btn btn-primary mx-1 toggler" data-toggle="toggler-<?php echo $contract['id']; ?>">Mostrar pagos realizados</button>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
        <?php foreach ($courses as $course): ?>
            <div class="card mb-3" style="width: 100%">
                <div class="card-body">
                    <h5 class="card-title h2">Curso matrimonial <?php echo $course['fecha_inicio'].' - Templo '.$course['templo'] ?></h5>
                    <p class="card-text">
                        <b>Precio total:</b> <?php echo $course['costo'] ?>
                    </p>
                </div>
            </div>
        <?php endforeach; ?>
    </section>
    </section>
</div>

<script>
    var togglers = document.getElementsByClassName('toggler');
    for (let i = 0; i < togglers.length; i++)  {
        togglers[i].addEventListener('click', function (event) {
            let toToggle = document.getElementById(this.getAttribute('data-toggle'));
            if(toToggle.classList.contains('d-none')){
                toToggle.classList.remove('d-none')
            }else{
                toToggle.classList.add('d-none')
            }
        })
    }
</script>

</body>
</html>
