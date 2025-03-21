<?php Class Grupos extends Controller
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

    public function listarGrupo()
    {
        $data = $this->model->getGrupo();
        //Se crea un for para crear las acciones de los botones
        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]['estado'] == 1) {
                $data[$i]['estado'] = '<button class="btn btn-success" type="button" onclick="btnEliminarGrupo('.$data[$i]['id'].');"><i class="fa-solid fa-circle-check"></i></button>';
                
            $data[$i]['acciones'] = '<div>
<button class="btn btn-primary" type="button" onclick="btnEditarGrupo('.$data[$i]['id'].');" ><i class="fas fa-edit"></i></button>
</div>';
            } else {
                $data[$i]['estado'] = '<button class="btn btn-danger" type="button" onclick="btnReingresarGrupo('.$data[$i]['id'].');"><i class="fa-solid fa-circle-xmark"></i></button>';
                $data[$i]['acciones'] = '<div></div>';                
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
        $grupo = $_POST['grupo'];

        //Se colocó a lo último porque es para poder modificar los usuarios
        $id = $_POST['id'];

        //Se confirma
        if (empty($grupo)) {
            //Se crea un mensaje. Para ello se crea una variable
            $msg = "Todos los campos son obligatorios";
        } else {
            //Se verifica si id es igual a vacío, se hace la insersección de datos.
            if ($id == "") {
                    //Se crea una variable que accede al modelo y se manda a llamar al método registrarUsuarios junto con sus parámetros en el modelo
                    $data = $this->model->registrarGrupo($grupo);
                    //Se hace la verificación
                    if ($data == "ok") {
                        $msg = "si";
                        //Verficación de curp existente. Viene del modelo cliente
                    } else if ($data == "existe") {
                        $msg = "El grupo ya existe";
                    } else {
                        $msg = "Error al registrar el grupo";
                    }
                
            } else {
                //Se crea una variable que accede al modelo y se manda a llamar al método modificarCantidades junto con sus parámetros en el modelo
                $data = $this->model->modificarGrupo($grupo, $id);
                //Se hace la verificación
                if ($data == "modificado") {
                    $msg = "modificado";
                }else {
                    $msg = "Error al modificar grupo";
                }
            }
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    //Aquí se crea la función de editar indicando como parámetro que recibe un entero para que se ejecute en el index de Views/Usuarios
    public function editar(int $id)
    {
        //Se crea una ariable donde almacena el acceso al modelo curp (ClienteModel) llamando al método editarUser() indicando que recibe un parámetro entero, en este caso $id
        $data = $this->model->editarGrupo($id);

        //Se visualiza con un echo y un JSON, donde el JSON_UNESCAPED_UNICODE es para no tener problemas con los acentos
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    //Aquí se crea la función de eliminar indicando como parámetro que recibe dos enteros para que se ejecute en el index de Views/Usuarios
    public function eliminar(int $id)
    {
        //Se crea una variable donde almacena el acceso al modelo curp (UsuariosModel) llamando al método eeliminarUser() indicando que recibe dos parámetro un 0 y un entero, en este caso 0 y $id
        $data = $this->model->accionGrupo(0, $id); 

        //Se hace una validación
        if ($data == 1) {
            $msg = "ok";
        }else {
            $msg = "Error al cambiar el estado del grupo";
        }
        //Se visualiza con un echo y un JSON, donde el JSON_UNESCAPED_UNICODE es para no tener problemas con los acentos
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        //Elimina el proceso
        die();

    }  
    
     //Aquí se crea la función de reingresar indicando como parámetro que recibe un entero para que se ejecute en el index de Views/Usuarios
     public function reingresar(int $id)
     {
         //Se crea una ariable donde almacena el acceso al modelo curp (UsuariosModel) llamando al método eeliminarUser() indicando que recibe dos parámetros, en este caso 1 para cambiar el estado y $id
         $data = $this->model->accionGrupo(1, $id); 
 
         //Se hace una validación
         if ($data == 1) {
             $msg = "ok";
         }else {
             $msg = "Error al cambiar el estado de la cantidad";
         }
         //Se visualiza con un echo y un JSON, donde el JSON_UNESCAPED_UNICODE es para no tener problemas con los acentos
         echo json_encode($msg, JSON_UNESCAPED_UNICODE);
         //Elimina el proceso
         die(); 
     }
}
