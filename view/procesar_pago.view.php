
<?php
require 'navbar.php';
?>
<br>
<br>
<br>
<h2 class="text-center">
    Procesar pago
</h2>
<div class="container">
    <div class="row">
        <form class="form-group m-auto p-3 border" style="width: 70%" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <div class="form-group">
                <div class="form-group">
                    <label>Metodos de pago registrados:</label>
                    <select class="form-control" name="metodo">
                        <option value="add">Agregar nuevo</option>
                        <?php foreach ($pay_methods as $meth): ?>
                            <?php if($meth['tipo'] !== 'TRANSFERENCIA'): ?>
                                <option value="<?php echo $meth['id'] ?>"><?php echo $meth['tipo'].' - Num: '.$meth['numero'] ?></option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group form-inline">
                    <label>Monto a pagar: </label>
<!--                    PONER COMO MAXIMO Y VALOR POR DEFECTO LA RESTA ENTRE EL PRECIO DEL CONTRATO Y LA SUMATORIA DE PAGOS-->
                    <input name="count" class="mx-2 form-control" type="number" min="1" max="<?php echo isset($total)?$total:'' ?>" value="<?php echo isset($total)?$total:'' ?>">
                    <?php echo isset($id_contract)? '<span>(Puede seleccionar un monto menor al indicado y pagar por partes)</span>':'' ?>
                </div>
                <label>Selecciona tu forma de pago:</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="metodo_pago" id="exampleRadios1" value="TRANSFERENCIA" checked>
                    <label class="form-check-label" for="exampleRadios1">
                        Transferencia
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="metodo_pago" id="exampleRadios2" value="TDD">
                    <label class="form-check-label" for="exampleRadios2">
                        Tarjeta de debito
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="metodo_pago" id="exampleRadios3" value="TDC">
                    <label class="form-check-label" for="exampleRadios3">
                        Tarjeta de credito
                    </label>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Banco</label>
                <input name="banco" class="form-control " type="text" placeholder="Banco Ejemplo">
            </div>
            <div class="form-group">
                <label class="form-label">Numero de tarjeta/transferencia</label>
                <input name="numero" class="form-control " type="text" placeholder="#">
            </div>
            <div class="form-group">
                <label class="form-label">Fecha de vencimiento tarjeta</label>
                <input name="fecha_ven" class="form-control " type="date" placeholder="#">
            </div>
            <div class="form-group">
                <label class="form-label">Codigo de seguridad de tarjeta</label>
                <input name="codigo" class="form-control " type="text" placeholder="#">
            </div>
            <?php if(isset($id_contract)): ?>
                <input class="d-none" name="contractToPay" value="<?php echo $id_contract ?>">
            <?php endif; ?>
            <?php if(isset($id_course1) and isset($id_course2)): ?>
                <input class="d-none" name="courseToPay1" value="<?php echo $id_course1 ?>">
                <input class="d-none" name="courseToPay2" value="<?php echo $id_course2 ?>">
            <?php endif; ?>
            <ul class="text-danger">
                <?php echo isset($error)? $error : ''; ?>
            </ul>
            <div class="row">
                <div class="col-md-6 text-center">
                    <a href="products" type="button" class="btn btn-danger">Volver</a>
                </div>
                <div class="col-md-6 text-center">
                    <button type="submit" class="btn btn-success">Pagar</button>
                </div>
            </div>
        </form>
    </div>
</div>
</body>
</html>
