<?php
class ClientesG extends Controller
{
    //Este constructor se hace igual en el controlador home
    public function __construct()
    {
        
            //Esto inicializa las sesiones
            session_start();

            //Se verifica si no se tiene una sesión activa. empty es Si no existe
        if (empty($_SESSION['activo']) || $_SESSION['id_ruta'] != 1) {
            //Si no se tiene una sesión activa. Se le manda mediante header la locación concatenada con la constante almacenada "base_url"
            header("location: ".base_url);
        }
            
            //La palabra reservada parent nos sirve para llamarla desde una clase extendida.
            //Cargar el constructor a las vistas
            parent::__construct();
        
    }
    
    //Accede al index de la carpeta Usuarios de la carpeta Views
    public function index()
    {
        
            $this->views->getView($this, "index");
        
            
    }

    public function listarClientesG()
    {
        
        $data = $this->model->getClientesG();
        //Se crea un for para crear las acciones de los botones
        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]['total_pago'] == 0 & $data[$i]['saldo']==0) {
                $data[$i]['total_pago']='<td> Sin crédito </td>';
                $data[$i]['saldo']='<td>$ 0</td>';

                $data[$i]['acciones'] = '<div>
                <!--Dentro del btnEditarUser y btnEliminarUser se concatena la variable $data en el indice $i y se le pasa al campo id, para que tome solo ese usuario que se le indica-->
<button class="btn btn-primary" type="button" onclick="btnInfoCliente('.$data[$i]['id'].');" ><i class="fas fa-user"></i></button>
<button class="btn btn-secondary" type="button" onclick="btnHistorialCliente('.$data[$i]['id'].');" ><i class="fas fa-history"></i></button>

</div>';
            }else{
                $data[$i]['total_pago']='<td>'."$ " .$data[$i]['total_pago'].' </td>';
                $data[$i]['saldo']='<td>'."$ ".$data[$i]['saldo'].'</td>';
                $data[$i]['acciones'] = '<div>
                                                                <!--Dentro del btnEditarUser y btnEliminarUser se concatena la variable $data en el indice $i y se le pasa al campo id, para que tome solo ese usuario que se le indica-->
            <button class="btn btn-primary" type="button" onclick="btnInfoCliente('.$data[$i]['id'].');"><i class="fas fa-user"></i></button>
            <button class="btn btn-secondary" type="button" onclick="btnHistorialCliente('.$data[$i]['id'].');" ><i class="fas fa-history"></i></button>
            <button class="btn btn-warning" type="button" onclick="btnBorrarCredito('.$data[$i]['id'].');" ><i class="fas fa-x"></i></button>
        </div>';
                
            }
            
            if ($data[$i]['estado'] == 1) {
                $data[$i]['estado'] = '<button class="btn btn-success" type="button" onclick="btnEliminarCliente('.$data[$i]['id'].');"><i class="fa-solid fa-circle-check"></i></button>';
                
                
            }else{                
                $data[$i]['estado'] = '<button class="btn btn-danger" type="button" onclick="btnReingresarCliente('.$data[$i]['id'].');"><i class="fa-solid fa-circle-xmark"></i></button>';
                

            }
        }

        //Mandamos el JSON a la función JS
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
        
    }


    //Aquí se crea la función de registrar para que se ejecute en el index de Views/Usuarios
    public function registrar()
    {
        //Se almacenan los valores que se obtengan por el método Post de los campos de la bd
        $nombre = $_POST['nombre'];
        $edad = $_POST['edad'];
        $telefono = $_POST['telefono'];
        $direccion = $_POST['direccion'];
        $trabajo = $_POST['trabajo'];
        $fecharegistro = $_POST['fecharegistro'];
        
        //Se colocó a lo último porque es para poder modificar los usuarios
        $id = $_POST['id'];

        //Se confirma
        if (empty($nombre)|| empty($edad) ||empty($telefono) || empty($direccion) || empty($trabajo) || empty($fecharegistro)) {
            //Se crea un mensaje. Para ello se crea una variable
            $msg = "Todos los campos son obligatorios";
        } else {
            //Se verifica si id es igual a vacío, se hace la insersección de datos.
            if ($id == "") {
                    //Se crea una variable que accede al modelo y se manda a llamar al método registrarUsuarios junto con sus parámetros en el modelo
                    $data = $this->model->registrarClientes($nombre, $edad, $telefono, $direccion, $trabajo, $fecharegistro);
                    //Se hace la verificación
                    if ($data == "ok") {
                        $msg = "si";
                        //Verficación de usuario existente. Viene del modelo usuario
                    } else if ($data == "existe") {
                        $msg = "El Cliente ya existe";
                    } else {
                        $msg = "Error al registrar al cliente";
                    }
                
            } else {
                //Se crea una variable que accede al modelo y se manda a llamar al método modificarUsuarios junto con sus parámetros en el modelo
                $data = $this->model->modificarClientes($nombre, $edad, $telefono, $direccion, $trabajo, $fecharegistro, $id);
                //Se hace la verificación
                if ($data == "modificado") {
                    $msg = "modificado";
                }else {
                    $msg = "Error al modificar usuario";
                }
            }
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    //Aquí se crea la función de editar indicando como parámetro que recibe un entero para que se ejecute en el index de Views/Usuarios
    public function infoCliente(int $id)
    {
        //Se crea una ariable donde almacena el acceso al modelo usuario (UsuariosModel) llamando al método editarUser() indicando que recibe un parámetro entero, en este caso $id
        $data = $this->model->infoClientes($id);

        // header('Content-Type: application/json');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function histoClientesG($id)
    {
        
        $data = $this->model->getPagosClientesG($id);

        //Mandamos el JSON a la función JS
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
        
    }

    //Aquí se crea la función de eliminar indicando como parámetro que recibe dos enteros para que se ejecute en el index de Views/Usuarios
    public function eliminarCredito($id)
    {
        //Se crea una variable donde almacena el acceso al modelo usuario (UsuariosModel) llamando al método eeliminarUser() indicando que recibe dos parámetro un 0 y un entero, en este caso 0 y $id
        $data = $this->model->borrarCreditoCliente($id);

        //Se hace una validación
        if ($data == 1) {
            $msg = "ok";
        }else {
            $msg = "Error al eliminar el crédito del cliente";
        }
        //Se visualiza con un echo y un JSON, donde el JSON_UNESCAPED_UNICODE es para no tener problemas con los acentos
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        //Elimina el proceso
        die();

    }  

    public function eliminarPagoID($id){
        $data = $this -> model -> borrarPagoIdCliente($id);
        if($data == 1){
            $msg = "ok";
        }else{
        $msg = "Error al eliminar el pago del cliente";
        }

        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    
    }
    
     //Aquí se crea la función de salir para que se ejecute en el index de Views/Usuarios
    public function salir()
    {
        //Se destruye las sesiones
        session_destroy();

        //Se le agrega el header y dentro se le coloca la locación concatenada con la constante base_url, para que lo mande al login o index principal, es decir, que que ingrese de nueo sesión
        header("location: ".base_url);
    }

}
