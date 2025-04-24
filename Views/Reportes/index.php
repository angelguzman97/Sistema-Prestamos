<title>Reportes</title>
<?php include "Views/Templates/header.php"; ?>
<script src="<?php echo base_url; ?>Assets/js/funcionesReporte.js"></script>

<ol class="breadcrumb mb-4 bg-light">
    <li class="breadcrumb-item active fw-bolder fs-4" style="color: black;">Cuadre diario</li>
</ol>
<!--Botón de agregar nuevo Cliente-->
<button class="btn btn-warning mb-2" data-toggle="collapse" type="button" onclick="frmCuadre();"><i class="fa-solid fa-plus"></i></button>
<!--El cuerpo de la tabla está almacenado en una variable con una función de ajax. Vor eso se le colocó un id la tabla-->
<table class="table table-responsive" id="tblPagosDia">
    <thead class="thead table-dark">
        <tr>
            <th>ID</th>
            <th>Fecha</th>
            <th>Hora</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td></td>
        </tr>
    </tbody>
</table>

<div id="nuevo_reporte" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <!--Se cambia el id del h5 para poder acceder a la función btnEditarUser-->
                <h5 class="modal-title text-white" id="title">Nuevo Reporte</h5>
                <button class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Formulario de cliente -->
                <form id="frmPagosDia">
                    <?php foreach ($data['ClientesPagos'] as $row['ClientesPagos']) { ?>
                        <?php foreach ($data['ClientesPrestamos'] as $row['ClientesPrestamos']) { ?>
                            <div for="clientes">
                                <div class="form-group"><label for="clientes programados" class="fw-bold">Clientes Programados:
                                    </label><input class="ms-1" style="border: 0; width: 35px;" id="clientes_programados" name="clientes_programados" value="<?php echo $row['ClientesPagos']['programados'] ?>" readonly>
                                    <input type="hidden" id="id" name="id">
                                </div>

                                <div class="col-6">
                                    <div class="form-group mt-2"><label for="clientes visitados" class="fw-bold">Clientes
                                            Visitados:</label><input style="border: 0; width: 35px;" id="clientes_visitados" name="clientes_visitados" class="ms-2" value="<?php echo $row['ClientesPagos']['visitados'] ?>" readonly></div>
                                </div>
                                <div class="col-6">
                                    <?php if ($row['ClientesPagos']['pendiente'] == "") {
                                    $row['ClientesPagos']['pendiente'] = 0;
                                } ?>
                                    <div class="form-group mt-2"><label for="clientes pendientes" class="fw-bold">Clientes
                                            Pendientes:</label><input style="border: 0; width: 35px;" id="clientes_pendientes" name="clientes_pendientes" value="<?php echo $row['ClientesPagos']['pendiente'] ?>" readonly></div>
                                </div>
                            </div>
                            <!-------------Caja inicial-------------------->
                            <div for="caja inicial">
                                <div class="col-6">
                                    <div class="form-group mt-2"><label for="Caja" class="fw-bold">Caja Inicial: $</label><input style="border: 0; width: 70px;" id="caja_inicial" name="caja_inicial" value="<?php echo $row['ClientesPagos']['caja_inicial'] ?>" readonly></div>
                                </div>
                            </div>
                            <!-------------Caja anterior-------------------->
                            <div for="caja_anterior">
                                <div class="col-6">
                                    <div class="form-group mt-2"><label for="Caja Anterior" class="fw-bold">Caja Anterior: $</label><input style="border: 0; width: 70px;" id="caja_anterior" name="caja_anterior" value="<?php echo $row['ClientesPagos']['caja_anterior'] ?>" readonly></div>
                                </div>
                            </div>
                            <!-------------ingresos y cobros-------------------->
                            <div for="ingresos y cobros">
                                <?php if ($row['ClientesPagos']['cobrado'] == "") {
                                    $row['ClientesPagos']['cobrado'] = 0;
                                } ?>
                                <div class="col-6">
                                    <div class="form-group mt-2"><label for="cobrado" class="fw-bold">Abonos: $</label><input style="border: 0; width: 70px;" id="cobrado" name="cobrado" value="<?php echo $row['ClientesPagos']['cobrado'] ?>" readonly></div>
                                </div>
                            </div>

                            <!-------------Retiros, Prestamos y Gastos-------------------->
                            <div for="Retiros, Prestamos y Gastos">
                                <?php if ($row['ClientesPrestamos']['prestamo'] == "") {
                                    $row['ClientesPrestamos']['prestamo'] = 0;
                                } ?>
                                <div class="col-6">
                                    <div class="form-group mt-2"><label for="prestamo" class="fw-bold">Ventas:
                                            $</label><input style="border: 0; width: 70px;" id="prestamo" name="prestamo" value="<?php echo $row['ClientesPrestamos']['prestamo'] ?>" readonly></div>
                                </div>

                                <div class="col-6">
                                    <div class="form-group mt-2"><label for="gastos" class="fw-bold">Gastos: $</label>
                                        <input style="width: 70px;" id="gastos" name="gastos" value="0">
                                    </div>
                                </div>
                                <textarea id="tipo_gastos" class="form-control" style="width: 200px; height: 150px;" name="tipo_gastos" placeholder="Especifique los gastos que tuvo"></textarea>
                                
                                <div class="col-6">
                                    <div class="form-group mt-2"><label for="inversion" class="fw-bold">Inversión: $</label>
                                        <input style="width: 70px;" id="inversion" name="inversion" value="0">
                                    </div>
                                </div>
                                <textarea id="tipo_inversion" class="form-control" style="width: 200px; height: 150px;" name="tipo_inversion" placeholder="Especifique las inversiones que hubo"></textarea>
                            </div>

                            <!-------------Caja final-------------------->
                            <div for="caja final">
    <div class="col-6">
        <div class="form-group mt-2">
            <label for="Caja final" class="fw-bold">Caja Real: $</label>
            
            <input style="border: 0; width: 100px;" id="caja_final" name="caja_final" value="<?php
            
            $caja_anterior = $row['ClientesPagos']['caja_anterior'];
            $caja_inicial = $row['ClientesPagos']['caja_inicial'];
            $ventas= $row['ClientesPrestamos']['prestamo'];
            $abonos= $row['ClientesPagos']['cobrado'];
            
             date_default_timezone_set('America/Chihuahua');
            setlocale(LC_TIME, 'es_MX');

            $dia_semana = date('N');
            if($dia_semana == 1){
                $caja_real1 = $caja_inicial;
            }else{
             $caja_real1=0;   
            }
            
            if($caja_anterior>0){
                $caja_real = $caja_anterior+$abonos-$ventas;
            }else{
            $caja_real = $caja_real1+$caja_anterior+$abonos-$ventas;
                
            }
            echo $caja_real ?>" readonly>
        </div>
    </div>
</div>

                        <?php } ?>
                    <?php } ?>

                    <div class="row">
                        <div class="col-6">
                            <div class="form-group mt-2">
                                <label for="fecha" class="fw-bold">Fecha</label>
                                <input id="fecha" style="border: 0; width: 130px;" name="fecha" value="<?php date_default_timezone_set('America/Chihuahua');
                                                                                                        setlocale(LC_TIME, 'es_MX');
                                                                                                        echo date('j/n/Y');  ?>" readonly></input>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group mt-2">
                                <label for="hora" class="fw-bold">Hora</label>
                                <input id="hora" style="border: 0; width: 100px;" name="hora" value="<?php date_default_timezone_set('America/Chihuahua');
                                                                                                        echo date('h:i A'); ?>" readonly></input>
                            </div>
                        </div>
                    </div>


                </form>
                <button class="btn btn-primary mt-2" type="button" id="btnAccion" onclick="registrarCuadre(event);">Registrar</button>
                <button class="btn btn-danger mt-2" type="button" data-bs-dismiss="modal">Cancelar</button>
                <button class="btn btn-warning mt-2" type="button" id="btnPDF" onclick="generarPDF();">Generar
                    PDF</button>
                </form>
            </div>
        </div>
    </div>
</div>



<?php include "Views/Templates/footer.php"; ?>