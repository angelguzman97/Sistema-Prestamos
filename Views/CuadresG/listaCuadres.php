<title>Cuadre semanales</title>
<?php include "Views/Templates/header.php"; ?>
<script src="<?php echo base_url; ?>Assets/js/funcionesCuadres.js"></script>
<ol class="breadcrumb mb-4 bg-light">
    <li class="breadcrumb-item active fw-bolder fs-4" style="color: black;">Lista de cuadres semanales</li>
</ol>

<!--El cuerpo de la tabla está almacenado en una variable con una función de ajax. Vor eso se le colocó un id la tabla-->

<table class="table table-responsive" id="tblCSemanal">
    <thead class="thead table-dark">
        <tr>
            <th>ID</th>
            <th>Ruta</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td></td>
        </tr>
    </tbody>
</table>


<!-- Modal saldo cliente-->

<div id="historial_cuadreS" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <!--Se cambia el id del h5 para poder acceder a la función btnEditarUser-->
                <h5 class="modal-title text-white" id="title">Cuadre Gral.</h5>
                <button class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-responsive" id="tblCuadreS">
                </table>
            </div>
        </div>
    </div>
</div>


<?php include "Views/Templates/footer.php"; ?>
<link href="<?php echo base_url; ?>Assets/css/styles.css" rel="stylesheet" />