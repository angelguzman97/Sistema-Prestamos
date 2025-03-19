<title>Clientes</title>
<?php include "Views/Templates/header.php"; ?>
<script src="<?php echo base_url; ?>Assets/js/funcionesClientes.js"></script>
<ol class="breadcrumb mb-4 bg-light">
    <li class="breadcrumb-item active fw-bolder fs-4" style="color: black;">Lista de Clientes</li>
</ol>

<!--El cuerpo de la tabla está almacenado en una variable con una función de ajax. Vor eso se le colocó un id la tabla-->
<table class="table table-responsive" style="text-align: center;" id="tblClientes">
    <thead class="thead table-dark">
        <tr>
            <th>Cliente</th>
            <th>Telefono</th>
            <th>Estado</th>
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
<div id="nuevo_cliente" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
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
                    <div class="form-group mt-2">
                        <label for="cliente">Nombre</label>
                        <input id="cliente" class="form-control" type="text" name="cliente" placeholder="Nombre del cliente">
                    </div>
                    <div class="form-group mt-2">
                        <label for="apellidos">Apellidos</label>
                        <input id="apellidos" class="form-control" type="text" name="apellidos" placeholder="Apellidos">
                    </div>
                    <div class="row">
                        <div class="col-3">
                            <div class="form-group mt-2">
                                <label for="edad">Edad</label>
                                <!--Esto es para mostrar el id en un input oculto agregado en cualquier parte del formulario-->
                                <input type="hidden" id="id" name="id"></input>
                                <input id="edad" class="form-control" type="number" name="edad" placeholder="edad">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group mt-2">
                        <label for="telefono">Teléfono</label>
                        <input id="telefono" class="form-control" type="text" name="telefono" placeholder="Número de teléfono">
                    </div>
                        </div>
                    </div>
                    <div class="form-group mt-2">
                        <label for="direccion">Dirección</label>
                        <textarea id="direccion" class="form-control" name="direccion" placeholder="Dirección"></textarea>
                    </div>
                    <div class="form-group mt-2">
                        <label for="trabajo">Trabajo</label>
                        <textarea id="trabajo" class="form-control" name="trabajo" placeholder="¿A qué se dedica?"></textarea>
                    </div>
                    <div class="col-md-12">
                            <div class="form-group">
                                <label>Foto</label>
                                <div class="card border-primary">
                                    <div class="card-body">
                                        <!--Se le coloca un id al label de la imagen-->
                                        <label for="imagen" id="icon-image" class="btn btn-primary"><i class="fas fa-image"></i></label>
                                        <!--Se le coloca un id al span para cerrar la imagen-->
                                        <span id="icon-cerrar"></span>
                                        <input id="imagen" class="d-none" type="file" name="imagen" onchange="preview(event);">
                                        <!--Se crean dos inputs ocultos para saber si el usuario cambió o eliminó la imagen y se les coloca un id y sus name para llamarlos en los controladores por metodo POST-->
                                        <input type="hidden" id="foto_actual" name="foto_actual">
                                        <!--Se crea esta etiqueta para previsualizar la imagen a subir y se le coloca un id-->
                                        <img class="img-thumbnail" id="img-preview">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                        <div class="col-6">
                            <div class="form-group mt-2">
                                <label for="fecharegistro" class="fw-bold">Fecha</label>
                                <input id="fecharegistro" style="border: 0; width: 130px;" name="fecharegistro"
                                    value="<?php date_default_timezone_set('America/Mexico_City');
                                                                                                            setlocale(LC_TIME, 'es_MX');
                                                                                                            echo strftime('%d de %B %Y'); ?>" readonly></input>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group mt-2">
                                <label for="hora_cliente" class="fw-bold">Hora</label>
                                <input id="hora_cliente" style="border: 0; width: 100px;" name="hora_cliente"
                                    value="<?php date_default_timezone_set('America/Mexico_City');
                                                                                                           echo date('h:i:s A'); ?>" readonly></input>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary mt-2" type="button" onclick="registrarCliente(event);" id="btnAccion">Registrar</button>
                    <button class="btn btn-danger mt-2" type="button" data-bs-dismiss="modal">Cancelar</button>
                </form>
            </div>
        </div>
    </div>
</div>


<?php include "Views/Templates/footer.php"; ?>
<link href="<?php echo base_url; ?>Assets/css/styles.css" rel="stylesheet" />