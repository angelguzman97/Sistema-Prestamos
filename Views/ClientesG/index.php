<title>Clientes</title>
<?php include "Views/Templates/header.php"; ?>
<script src="<?php echo base_url; ?>Assets/js/funcionesAdmin.js"></script>
<ol class="breadcrumb mb-4 bg-light">
    <li class="breadcrumb-item active fw-bolder fs-4" style="color: black;">Todos Los Clientes</li>
</ol>
<!--Botón de agregar nuevo Cliente-->

<!--El cuerpo de la tabla está almacenado en una variable con una función de ajax. Vor eso se le colocó un id la tabla-->
<table class="table table-responsive" id="tblClientesG">
    <thead class="thead table-dark">
        <tr>
            <th>Nombre</th>
            <th>Crédito</th>
            <th>Saldo</th>
            <th>Ruta</th>
            <th>Edo</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td></td>
        </tr>
    </tbody>
</table>
<!--------------------------Información--------------------------->
<div id="info_cliente" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <!--Se cambia el id del h5 para poder acceder a la función btnEditarUser-->
                <h5 class="modal-title text-white" id="title">Nuevo Cliente</h5>
                <button class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Formulario de cliente -->
                <form id="frmClientes" method="post">
                    <div class="form-group">
                        <label for="id" class="fw-bold">ID:</label>
                        <input style="border: 0;" id="id" type="text" name="id" readonly>
                    </div>
                    <div class="form-group">
                        <label for="nombre" class="fw-bold">Nombre(s): </label>
                        <input style="border: 0;" id="cliente" type="text" name="cliente" readonly>
                    </div>
                    <div class="form-group mt-2">
                        <label for="apellidos" class="fw-bold">Apellidos: </label>
                        <input id="apellidos" style="border: 0;" type="text" name="apellidos" readonly>
                    </div>
                    <div class="row">
                        <div class="col-3 form-group mt-2">
                            <label for="edad" class="fw-bold">Edad</label>
                            <input id="edad" style="border: 0;" type="number" name="edad" readonly>
                        </div>
                        <div class="col-4 form-group mt-2">
                            <label for="telefono" class="fw-bold">Teléfono</label>
                            <input id="telefono" style="border: 0;" type="text" name="telefono" readonly>
                        </div>
                    </div>
                    <div class="form-group mt-2">
                        <label for="direccion" class="fw-bold">Dirección: </label>
                        <input id="direccion" style="border: 0;" name="direccion" readonly>
                    </div>
                    <div class="form-group mt-2">
                        <label for="trabajo" class="fw-bold">Trabajo: </label>
                        <input id="trabajo" style="border: 0;" name="trabajo" readonly>
                    </div>
                    <div class="col-md-12 w-50">
                        <div class="form-group">
                            <label class="fw-bold" class="fw-bold">Foto</label><br>
                            <!--Se crea esta etiqueta para previsualizar la imagen a subir y se le coloca un id-->
                            <img class="img-thumbnail" src="" id="img-preview">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group  col-4">
                            <label for="fecharegistro" class="fw-bold">Fecha de registro</label>
                            <input id="fecharegistro" style="border: 0;" type="text" name="fecharegistro" readonly>
                        </div>
                        <div class="form-group  col-4">
                            <label for="hora_cliente" class="fw-bold">Hora de registro</label>
                            <input id="hora_cliente" style="border: 0;" type="text" name="hora_cliente" readonly>
                        </div>
                    </div>

                    <div for="Datos del prestamo del cliente" id="pres" name="pres">
                        <div class="form-group mt-2">
                            <input type="hidden" id="id_prestamo" name="id_prestamo">
                            <label for="prestamo" class="fw-bold">Préstamo: $</label>
                            <input id="total_pago" name="total_pago" style="border: 0;" type="text" readonly>
                        </div>
                        <div class="form-group mt-2" id="grup">
                            <input type="hidden" id="id_grupo" name="id_grupo">
                            <label for="grupo" class="fw-bold">Grupo:</label>
                            <input id="grupo" name="grupo" style="border: 0;" type="text" readonly>
                        </div>

                        <div class="form-group mt-2" id="cuota">
                            <label for="pago diario" class="fw-bold">Cuota diaria: $</label>
                            <input id="cantidad_dias" name="pago_diario" style="border: 0; width: 70px;" readonly>
                        </div>

                        <div class="form-group mt-2" id="fecha">
                            <label for="fecha inicial y final" class="fw-bold">Fecha inicial y final del préstamo:</label>
                            <br>
                            <input style="border: 0; width: 100px;" id="fecha_inicial" name="fecha_inicial" readonly>
                            <label id="al" class="fw-bold" name="al">al</label>
                            <input style="border: 0; width: 100px;" id="fecha_final" name="fecha_final" readonly>
                        </div>
                    </div>

                    <div for="Datos del pago del cliente" id="sal">
                        <div class="form-group fw-bold mt-2">
                            <label for="saldo">Saldo: $</label>
                            <input style="border: 0; width: 80px;" id="saldo" name="saldo" readonly >
                        </div>

                        <div class="row" id="filas">
                            <div class="col-6">
                                <div class="form-group mt-2">
                                    <label for="cuota vencida" class="fw-bold">Cuotas vencidas:</label>
                                    <input style="border: 0; width: 35px;" id="cuotas_vencidas" name="cuotas_vencidas" readonly >
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="form-group mt-2">
                                    <label for="dias_atraso" class="fw-bold">Días de atraso:</label>
                                    <input style="border: 0; width: 35px;" id="dias_atraso" name="dias_atraso" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mt-2" id="salV">
                            <label for="saldo_vencido" class="fw-bold">Saldo vencido: $</label>
                            <input style="border: 0; width: 65px;" id="saldo_vencido" name="saldo_vencido" readonly>
                        </div>

                    </div>


                    <button class="btn btn-danger mt-2" type="button" data-bs-dismiss="modal">Cerrar</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-------------------------------Historial------------------------>
<div id="histo_cliente" class="modal fade" style="width:auto" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <!--Se cambia el id del h5 para poder acceder a la función btnEditarUser-->
                <h5 class="modal-title text-white" id="title">Historial</h5>
                <button class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-responsive" id="tblHistoClientesG">
                </table>

            </div>
        </div>
    </div>
</div>


<link href="<?php echo base_url; ?>Assets/css/styles.css" rel="stylesheet" />
<?php include "Views/Templates/footer.php";  ?>