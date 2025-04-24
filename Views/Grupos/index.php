<title>Grupos</title>
<?php include "Views/Templates/header.php"; ?>
<script src="<?php echo base_url; ?>Assets/js/funcionesGrupos.js"></script>
<ol class="breadcrumb mb-4 bg-light">
    <li class="breadcrumb-item active fw-bolder fs-4" style="color: black;">Grupos</li>
</ol>
<!--Botón de agregar nuevo cantidad-->
<button class="btn btn-primary mb-2" type="button" onclick="frmGrupo();"><i class="fa-solid fa-plus"></i></button>
<!--El cuerpo de la tabla está almacenado en una variable con una función de ajax. Vor eso se le colocó un id la tabla-->
<table class="table table-responsive" style="text-align: center;" id="tblGrupos">
    <thead class="thead table-dark">
        <tr>
            <th>Grupos</th>
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
<!-- Modal header-->
<div id="nuevo_grupo" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <!--Se cambia el id del h5 para poder acceder a la función btnEditarUser-->
                <h5 class="modal-title text-white" id="title">Nuevo Grupo</h5>
                <button class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Formulario de cantidad -->
                <form id="frmGrupos" method="post">
                    <div class="form-group mt-2">
                        <label for="grupo">Grupos</label>
                        <!--Esto es para mostrar el id en un input oculto agregado en cualquier parte del formulario-->
                        <input type="hidden" id="id" name="id"></input>
                        <input id="grupo" class="form-control" type="text" name="grupo" placeholder="Grupos">
                    </div>
                    <button class="btn btn-primary mt-2" type="button" onclick="registrarGrupo(event);" id="btnAccion">Registrar</button>
                    <button class="btn btn-danger mt-2" type="button" data-bs-dismiss="modal">Cancelar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include "Views/Templates/footer.php"; ?>
<link href="<?php echo base_url; ?>Assets/css/styles.css" rel="stylesheet" />