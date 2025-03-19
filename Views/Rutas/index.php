<title>Rutas</title>
<?php include "Views/Templates/header.php"; ?>
<script src="<?php echo base_url; ?>Assets/js/funcionesUsuarios.js"></script>
<ol class="breadcrumb mb-4 bg-light">
    <li class="breadcrumb-item active fw-bolder fs-4" style="color: black;">Rutas</li>
</ol>
<!--Botón de agregar nuevo ruta-->
<button class="btn btn-primary mb-2" type="button" onclick="frmRuta();"><i class="fa-solid fa-user-plus"></i></button>
<!--El cuerpo de la tabla está almacenado en una variable con una función de ajax. Vor eso se le colocó un id la tabla-->
<table class="table table-responsive" id="tblRutas">
    <thead class="thead table-dark">
        <tr>
            <th style="width: 20px;">Ruta</th>
            <th style="width: 20px;">Estado</th>
            <th style="width: 80px;"></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td></td>
        </tr>
    </tbody>
</table>
<!-- Información de las Rutas-->
<div id="nueva_ruta" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <!--Se cambia el id del h5 para poder acceder a la función btnEditarUser-->
                <h5 class="modal-title text-white" id="title">Nueva Ruta</h5>
                <button class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Formulario de ruta -->
                <form id="frmRutas" method="post">
                    
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
                    
                    <div class="form-group">
                        <label for="ruta" class="fw-bold">Ruta</label>
                        <!--Esto es para mostrar el id en un input oculto agregado en cualquier parte del formulario-->
                        <input type="hidden" id="id" name="id"></input>
                        <input id="ruta" class="form-control w-50" type="text" name="ruta" placeholder="Ruta/Usuario">
                    </div>
                    <div class="form-group mt-2">
                        <label for="caja" class="fw-bold">Caja: $</label>
                        <input style="border-color:darkgray; width: 100px;" id="caja" type="number" name="caja" placeholder="Caja">
                    </div>
                    
                    <div class="form-group mt-2" id="fecha_caja">
                        <label for="fecha" class="fw-bold">Fecha de la caja anterior:</label>
                        <input id="fecha_ruta" style="border: 0; width: 130px;"  name="fecha_ruta" readonly></input>
                    </div>
                    <div class="form-group mt-2">
                        <label for="nombre" class="fw-bold">Nombre</label>
                        <input id="nombre" class="form-control" type="text" name="nombre" placeholder="Nombre">
                    </div>
                    <div class="form-group mt-2">
                        <label for="telefono" class="fw-bold">Núm. De teléfono</label>
                        <input id="telefono" class="form-control w-50" type="text" name="telefono" placeholder="Núm. De tel.">
                    </div>
                    <div class="form-group mt-2" id="clave_actual">
                        <label for="contraseña" class="fw-bold">Contraseña Actual:</label>
                        <input id="contrasena" style="border: 0; width: 130px;" type="text" name="contrasena" readonly>
                    </div>

                    <!--Se le agrega un id a las fias de las contraseñas para ocultarlos al editar los rutas y no se visualicen y que el ruta pueda cambiarlo por sí mismo-->
                    <div class="row" id="claves">
                        <div class="col-md-6">
                            <div class="form-group mt-2">
                                <label for="clave" class="fw-bold">Contraseña:</label>
                                <input id="clave" class="form-control" type="password" name="clave" placeholder="Contraseña">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mt-2">
                                <label for="confirmar" class="fw-bold">Confirmar contraseña:</label>
                                <input id="confirmar" class="form-control" type="password" name="confirmar" placeholder="Confirmar contraseña">
                            </div>
                        </div>
                    </div>
                                       
                    <button class="btn btn-primary mt-2" type="button" onclick="registrarRuta(event);" id="btnAccion">Registrar</button>
                    <button class="btn btn-danger mt-2" type="button" data-bs-dismiss="modal">Cancelar</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Lista de clientes de las Rutas-->
<div id="lista_cliente" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <!--Se cambia el id del h5 para poder acceder a la función btnEditarUser-->
                <h5 class="modal-title text-white" id="title">Lista de clientes</h5>
                <button class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-responsive tblListaClientes" id="tblListaClientes">
                </table>
                 
            </div>
        </div>
    </div>
</div>
<!-- Lista de reportes de las Rutas-->
<div id="lista_reporte" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <!--Se cambia el id del h5 para poder acceder a la función btnEditarUser-->
                <h5 class="modal-title text-white" id="title">Lista de reportes</h5>
                <button class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-responsive tblListaReportes" id="tblListaReportes">
                </table>
                 
            </div>
        </div>
    </div>
</div>

<?php include "Views/Templates/footer.php"; ?>
<link href="<?php echo base_url; ?>Assets/css/styles.css" rel="stylesheet" />