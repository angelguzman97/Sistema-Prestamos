<title>Perfil</title>
<?php include "Views/Templates/header.php"; ?>
<script src="<?php echo base_url; ?>Assets/js/funcionesPerfil.js"></script>
<div class="card">
    <div class="card-header bg-dark text-white fs-4">
        Perfil
    </div>
    <div class="card-body">
        <h1>¡Bienvenido, <?php echo $_SESSION['ruta']; ?>!</h1>
        <form id="frmPerfil">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <input id="id" class="form-control" type="hidden" name="id" value="<?php echo $data['id'] ?>">
                        <label for="ruta">Ruta</label>
                        <input id="ruta" class="form-control" type="text" name="ruta" placeholder="Jáltipan" value="<?php echo $data['ruta'] ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input id="nombre" class="form-control" type="text" name="nombre" placeholder="Angel" value="<?php echo $data['nombre'] ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="telefono">Teléfono</label>
                        <input id="telefono" class="form-control" type="text" name="telefono" placeholder="9222456578" value="<?php echo $data['telefono'] ?>">
                    </div>
                </div>
                
            <button class="btn btn-primary mt-2" type="button" id="btnAccion" onclick="modificarPerfil(event)">Modificar</button>
        </form>
    </div>
</div>

<?php include "Views/Templates/footer.php"; ?>