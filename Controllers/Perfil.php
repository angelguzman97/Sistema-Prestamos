<?php
class Perfil extends Controller{
//Este constructor se hace igual en el controlador home
public function __construct()
{
    //Esto inicializa las sesiones
    session_start();

    //La palabra reservada parent nos sirve para llamarla desde una clase extendida.
    //Cargar el constructor a las vistas
    parent::__construct();
}
public function index()
{
    //Se verifica si no se tiene una sesión activa. empty es Si no existe
    if (empty($_SESSION['activo'])) {
        //Si no se tiene una sesión activa. Se le manda mediante header la locación concatenada con la constante almacenada "base_url"
        header("location: ".base_url);
    }
    $id_ruta = $_SESSION['id_ruta'];
    $data = $this->model->perfilRuta($id_ruta);

    $this->views->getView($this, "index", $data);
}

public function editarPerfil()
{
    $ruta = $_POST['ruta'];
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];
    $id_ruta= $_SESSION['id_ruta'];

    $data = $this->model->editarPerfilRuta($ruta, $nombre, $telefono, $id_ruta);
    if ($data == "modificado") {
        $msg = "modificado";
    }else {
        $msg = "Error al modificar cantidad";
    }

    echo json_encode($msg, JSON_UNESCAPED_UNICODE);
    die();
}

}
?>