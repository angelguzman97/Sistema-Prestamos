<?php
//Se crea una clase
class Home extends Controller{
  public function __construct()
    {
        //Esto inicializa las sesiones
        session_start();

        //Esto es para privatizar las url
        //Se verifica si no se tiene una sesión activa. !empty es Si existe
        if (!empty($_SESSION['activo'])) {
            //Si se tiene una sesión activa. Se le manda mediante header la locación raíz concatenada con la constante almacenada "base_url" y se abre el controlador Usuarios y se envía al método index
            header("location: ".base_url."Perfil");
        }
        //La palabra reservada parent nos sirve para llamarla desde una clase extendida.
        //Cargar el constructor a las vistas
        parent::__construct();
    }
  
  //Se crea el método
    public function index()
    {
       $this->views->getView($this,"index");
    }
}
?>