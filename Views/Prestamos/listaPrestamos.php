<title>Prestamos</title>
<?php include "Views/Templates/header.php"; ?>
<script src="<?php echo base_url; ?>Assets/js/funcionesPrestamos.js"></script>
<ol class="breadcrumb mb-4 bg-light">
    <li class="breadcrumb-item active fw-bolder fs-4" style="color: black;">Lista de Créditos</li>
</ol>
<!--El cuerpo de la tabla está almacenado en una variable con una función de ajax. Vor eso se le colocó un id la tabla-->

<table class="table table-responsive" id="tblPrestamos">
    <thead class="thead table-dark">
        <tr>
            <th>Cliente</th>
            <th>Crédito</th>
            <th>Total a pagar</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td></td>
        </tr>
    </tbody>
</table>

<!-- Modal header  -->
<div id="nuevo_prestamo" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <!--Se cambia el id del h5 para poder acceder a la función btnEditarUser-->
                <h5 class="modal-title text-white" id="title">Nuevo Crédtio</h5>
                <button class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Formulario de cliente -->
                <form id="frmPrestamos" method="post">
                            <div class="form-group mt-2">
                            <input type="hidden" id="id" name="id"></input>
                                <input type="hidden" id="id_ruta" name="id_ruta"></input>
                                <input type="hidden" id="saldo" name="saldo"></input>
                                
                                <label for="cliente">Cliente</label>
                                <select id="cliente" class="form-select" style="width: auto;" name="cliente">
                                    <!-- Se recorre con un foreach. Donde row toma el valor de data-->
                                    <?php foreach ($data['clientes'] as $row) { ?>
                                        <!-- Se muestra row con el campo caja de la bd y en las etiquetas option se coloca el value para recibir los id de caja-->
                                        <option value="<?php  echo $row['id']; ?>"> <?php echo $row['cliente']." ".$row['apellidos']; ?> </option>
                                    <?php } ?>
                                </select>
                            </div>

                    <div class="row">
                        <div class="col-3 me-2" style="text-align: center;">
                            <div class="form-group mt-2">
                                <label for="credito" >Crédito</label>
                                <select id="credito" class="form-select" name="credito" style="width: auto;" onchange="calcularTotal();">
                                    <!-- Se recorre con un foreach. Donde row toma el valor de data-->
                                    <?php foreach ($data['cantidades'] as $row) { ?>
                                        <!-- Se muestra row con el campo caja de la bd y en las etiquetas option se coloca el value para recibir los id de caja-->
                                        <option value="<?php echo $row['id']; ?>"> <?php echo "$ " . $row['cantidad']; ?> </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-2 ms-4"  style="text-align: center;">
                            <div class="form-group mt-2">
                                <label for="porcentaje" style="text-align: center;">Porcentaje</label>
                                <input id="porcentaje" style="text-align: center; width: 60px;" value="20" class="form-control" name="porcentaje" readonly>
                            </div>
                        </div>
                        <div class="col-5 ms-1">
                            <div class="form-group mt-2"  style="text-align: center;">
                                <label for="total" style="text-align: right;">Total a pagar</label>
                                <input id="total" class="form-control"  name="total" placeholder="total" readonly>

                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-2 me-2"  style="text-align: center;">
                        <div class="form-group mt-2">
                            <label for="plazo">Plazo</label>
                        <select id="plazo" class="form-select" name="plazo" style="width: auto;">
                                <option value="15">15 días</option>
                                <option value="16">16 días</option>
                                <option value="18">18 días</option>
                                <option value="20">20 días</option>
                        </select>
                            </div>
                        </div> 
                        <div class="col-5 ms-4">
                            <div class="form-group mt-2"  style="text-align: center;">
                                <label for="cantidad_dia" style="text-align: right;">Pago por día</label>
                                <input id="cantidad_dia" class="form-control" name="cantidad_dia" placeholder="Pago por día" readonly>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group mt-2">
                                <label for="fecha_inicio">Fecha de registro</label>
                                <input id="fecha_inicio" class="form-control" name="fecha_inicio" value="<?php date_default_timezone_set('America/Mexico_City');
                                                                                                            setlocale(LC_TIME, 'es_MX');
                                                                                                            echo date('j/n/Y'); ?>" readonly></input>
                            </div>
                        </div>
                        <div class="col-4">
                                <div class="form-group mt-2">
                                    <label for="fecha_final">Final del pago</label>
                                    <input id="fecha_final" class="form-control" name="fecha_final" readonly></input>
                                </div>
                            </div>
                    </div>
                    <div class="row">
                            <div class="col-3">
                                <div class="form-group mt-2">
                                    <label for="hora_prestamo" class="fw-bold">Hora</label>
                                    <input id="hora_prestamo" style="border: 0; width: 100px;" name="hora_prestamo"
                                            value="<?php date_default_timezone_set('America/Chihuahua');
                                                                                                                echo date('h:i A'); ?>" readonly></input>
                                </div>
                            </div>
                            <div class="col-6">
                            <div class="form-group mt-2">
                                <label for="grupo" >Grupo</label>
                                <select id="grupo" class="form-select" name="grupo" style="width: auto;" onchange="calcularTotal();">
                                    <!-- Se recorre con un foreach. Donde row toma el valor de data-->
                                    <?php foreach ($data['grupos'] as $row) { ?>
                                        <!-- Se muestra row con el campo caja de la bd y en las etiquetas option se coloca el value para recibir los id de caja-->
                                        <option value="<?php echo $row['id']; ?>"> <?php echo $row['grupo']; ?> </option>
                                    <?php } ?>
                                </select>
                            </div>
                            </div>
                        </div>
                
                    <button class="btn btn-primary mt-2" type="button" onclick="registrarPrestamo(event);" id="btnAccion">Registrar</button>
                    <button class="btn btn-danger mt-2" type="button" data-bs-dismiss="modal">Cancelar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!--------------------------Información--------------------------->
<div id="info_cliente" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <!--Se cambia el id del h5 para poder acceder a la función btnEditarUser-->
                <h5 class="modal-title text-white" id="title">Adelantar Pago</h5>
                <button class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Formulario de cliente -->
                <form id="frmAdelantoPagos" method="post">
                    <div class="form-group">
                        <label for="id" class="fw-bold">ID:</label>
                        <input style="border: 0;" id="id_cliente" type="text" name="id_cliente" readonly>
                    </div>
                    <div class="form-group">
                        <label for="nombre" class="fw-bold">Nombre(s): </label>
                        <input style="border: 0;" id="clientes" type="text" name="cliente" readonly>
                    </div>
                    <div class="form-group mt-2">
                        <label for="apellidos" class="fw-bold">Apellidos: </label>
                        <input id="apellidos" style="border: 0;" type="text" name="apellidos" readonly>
                    </div>

                    <div for="Datos del prestamo del cliente">
                        <div class="form-group mt-2">
                            <input type="hidden" id="id_prestamo" name="id_prestamo">
                            <label for="prestamo" class="fw-bold">Préstamo: $</label>
                            <input id="total_pagos" name="total_pagos" style="border: 0;" type="text" readonly>
                        </div>
                        <div class="form-group mt-2">
                            <label for="grupo" class="fw-bold">Grupo:</label>
                            <input style="border: 0;" type="hidden" id="id_grupo" name="id_grupo" readonly>
                            <input id="grupos" name="grupos" style="border: 0;" type="text" readonly>
                        </div>

                        <div class="form-group mt-2">
                            <label for="pago diario" class="fw-bold">Cuota diaria: $</label>
                            <input id="cantidad_dias" name="pago_diario" style="border: 0; width: 70px;" readonly>
                        </div>

                        <div class="form-group mt-2">
                            <label for="fecha inicial y final" class="fw-bold">Fecha inicial y final del préstamo:</label>
                            <br>
                            <input style="border: 0; width: 100px;" id="fecha_inicial" name="fecha_inicial" readonly>
                            <label id="al" class="fw-bold" name="al">al</label>
                            <input style="border: 0; width: 100px;" id="fecha_finals" name="fecha_finals" readonly>
                        </div>
                    </div>

                    <div for="Datos del pago del cliente">
                        <div class="form-group fw-bold mt-2">
                            <label for="saldo">Saldo: $</label>
                            <input style="border: 0; width: 80px;" id="saldo1" name="saldo1" readonly >
                        </div>

                        <div class="form-group mt-2">
                            <label for="saldo_vencido" class="fw-bold">Saldo vencido: $</label>
                            <input style="border: 0; width: 65px;" id="saldo_vencido" name="saldo_vencido" readonly>
                        </div>

                        <div class="form-group mt-2">
                            <label for="pago" class="fw-bold">Abono/Pago: $</label>
                            <input style="width: 65px;" id="pago" type="number" name="pago">
                        </div>

                        <div class="form-group mt-2">
                        <select id="tipo_pago" class="form-select" name="tipo_pago" style="width: 150px;" >
                            <option value="Efectivo">Efectivo</option>
                            <option value="Transferencia">Transferencia</option>
                        </select>
                        </div>

                        <div class="row">
                        <div class="col-6">
                            <div class="form-group mt-2">
                                <label for="fecha_pago" class="fw-bold">Fecha</label>
                                <input id="fecha_pago" style="width: 130px;" name="fecha_pago"
                                    value="<?php date_default_timezone_set('America/Chihuahua');
                                                                                                            echo date('j/n/Y'); ?>"></input>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group mt-2">
                                <label for="hora_pago" class="fw-bold">Hora</label>
                                <input id="hora_pago" style="border: 0; width: 100px;" name="hora_pago"
                                    value="<?php date_default_timezone_set('America/Chihuahua');
                                    echo date('h:i A'); ?>" readonly></input>
                            </div>
                        </div>
                    </div>


                    </div>

                    <button class="btn btn-primary mt-2" type="button" onclick="adelantarPagos(event);" id="btnAccion">Registrar</button>
                    <button class="btn btn-danger mt-2" type="button" data-bs-dismiss="modal">Cerrar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include "Views/Templates/footer.php"; ?>
<link href="<?php echo base_url; ?>Assets/css/styles.css" rel="stylesheet"/>