<?php
    require 'navbar.php';
?>

<br>
<br>
<br>

<div class="container mt-1">
    <section class="row">
        <?php foreach ($contracts as $contract): ?>
            <div class="card" style="width: 100%">
                <div class="card-body">
                    <h5 class="card-title h2">Contrato <?php echo $contract['fecha_aprobado'] ?></h5>
                    <p class="card-text">
                        <b>Total a pagar:</b> <?php echo $contract['monto'] ?>
                        <span class="ml-auto"><a href="procesar_pago?idContract=<?php echo $contract['id'] ?>" class="btn btn-success">Pagar</a></span>
                    </p>
                    <div id="toggler-<?php echo $contract['id'] ?>" class="border-top border-bottom pt-2 d-none mb-3">
                        <div class="row">
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
                                <p class="card-text">
                                    <div class="row">
                                        <div class="col">Pago <?php echo $payment['fecha'] ?></div>
                                        <div class="col text-right">Monto: <?php echo $payment['monto'] ?></div>
                                    </div>
                                </p>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php if(sizeof($payments) > 0): ?>
                        <button type="button" class="btn btn-primary mx-1 toggler" data-toggle="toggler-<?php echo $contract['id']; ?>">Mostrar pagos realizados</button>
                    <?php endif; ?>
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
