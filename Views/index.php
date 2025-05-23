<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Login</title>
    <link href="<?php echo base_url; ?>Assets/logo.png" rel="icon"/>
    <link href="<?php echo base_url; ?>Assets/css/styles.css" rel="stylesheet" />
    <script src="<?php echo base_url; ?>Assets/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="bg-dark">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">    
                            <div class="card-header">
                            <img src="<?php echo base_url; ?>Assets/Usuario.png" style="margin:0% 40%;" width="100px" height="100px" alt="">
                                    <h3 class="text-center font-weight-light my-4">Ingreso al sistema</h3>
                                </div>
                                <div class="card-body">
                                    <!--El "id" de form sirve para hacer peticiones mediante AJAX-->
                                    <form id="frmLogin">
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="ruta" name="ruta" type="text" placeholder="User123" />
                                            <label for="ruta"><i class="fas fa-user"></i>Usuario</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="clave" name="clave" type="password" placeholder="Contraseña" />
                                            <label for="clave"><i class="fas fa-key"></i> Contraseña</label>
                                        </div>
                                    <div class="alert alert-danger text-center d-none" id="alerta" role="alert"></div>
                                        <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                            <button class="btn btn-primary" type="submit" onclick="frmLogin(event);">Iniciar Sesión</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <div id="layoutAuthentication_footer">
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; ClarkyGame <?php echo date("Y");?></div>
                        <div>
                            <a href="#">Politica de Privacidad</a>
                            &middot;
                            <a href="#">Términos &amp; Condiciones</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="<?php echo base_url;?>Assets/js/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
    <script src="<?php echo base_url;?>Assets/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="<?php echo base_url;?>Assets/js/scripts.js"></script>
    <script>
        const base_url = "<?php echo base_url;?>";
    </script>
    <script src="<?php echo base_url;?>Assets/js/login.js"></script>
</body>


</html>