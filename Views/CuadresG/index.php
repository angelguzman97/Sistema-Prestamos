<title>Cuadre semanal</title>
<?php include "Views/Templates/header.php"; ?>
<script src="<?php echo base_url; ?>Assets/js/funcionesCuadres.js"></script>
<ol class="breadcrumb mb-4 bg-light">
    <li class="breadcrumb-item active fw-bolder fs-4" style="color: black;">Agregar Cuadre Semanal</li>
</ol>

<!--El cuerpo de la tabla está almacenado en una variable con una función de ajax. Vor eso se le colocó un id la tabla-->

<table class="table table-responsive" id="tblCuadres">
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

<div id="cuadre_semanal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
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
                <table class="table table-responsive" id="tblCuadresG">
                </table>
                <form id="frmCuadres" method="post">
                    
                            <div class="form-group mt-2">
                                
                            <input type="hidden" id="id" name="id"></input>
                                <input type="hidden" id="id_ruta" name="id_ruta"></input>
                                <label for="total_abonos" style="text-align: right;" class="fw-bold">Abonos totales: $</label>
                                <input id="total_abonos" style="border: 0; width: auto;" type="text" name="total_abonos"readonly>
                            </div>
                           
                            <div class="form-group mt-2">
                                <label for="total_ventas" style="text-align: right;" class="fw-bold">Ventas totales: $</label>
                                <input id="total_ventas" style="border: 0; width: auto;" type="text" name="total_ventas" readonly>
                            </div>
                            
                            <div class="form-group mt-2">
                                <label for="total_gastos" style="text-align: right;" class="fw-bold">Gastos totales: $</label>
                                <input id="total_gastos" style="border: 0; width: auto;" type="text" name="total_gastos" readonly>
                            </div>
                            
                            <div class="form-group mt-2">
                                <label for="caja_semanal" style="text-align: right;" class="fw-bold">Caja total: $</label>
                                <input id="caja_semanal" style="border: 0; width: auto;" type="text" name="caja_semanal" placeholder="Caja real semanal" readonly>
                            </div>
                    
                            <div class="form-group mt-2">
                                <label for="fecha_semanal" class="fw-bold">Fecha de registro</label>
                                <input id="fecha_semanal" name="fecha_semanal" style="border: 0;" value="<?php date_default_timezone_set('America/Chihuahua');
                                                                                                            setlocale(LC_TIME, 'es_MX');
                                                                                                            echo date('j/n/Y'); ?>" readonly></input>
                            </div>                     
                
                    <button class="btn btn-primary mt-2" type="button" onclick="registrarCuadreS(event);" id="btnAccion" >Registrar</button>
                    <button class="btn btn-danger mt-2" type="button" data-bs-dismiss="modal">Cancelar</button>
                </form>
            </div>
        </div>
    </div>
</div>


<?php include "Views/Templates/footer.php"; ?>
<link href="<?php echo base_url; ?>Assets/css/styles.css" rel="stylesheet" />