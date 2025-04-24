<?php
class Prestamos extends Controller
{
    //Este constructor se hace igual en el controlador home
    public function __construct()
    {
        //Esto inicializa las sesiones
        session_start();

        //La palabra reservada parent nos sirve para llamarla desde una clase extendida.
        //Cargar el constructor a las vistas
        parent::__construct();
    }
    //Accede al index de la carpeta Usuarios de la carpeta Views
    public function index()
    {
        //Se verifica si no se tiene una sesión activa. empty es Si no existe
        if (empty($_SESSION['activo'])) {
            //Si no se tiene una sesión activa. Se le manda mediante header la locación concatenada con la constante almacenada "base_url"
            header("location: ".base_url);
        }
        $id_ruta = $_SESSION['id_ruta'];
    $data['clientes'] = $this->model->getCliente($id_ruta);
    $data['cantidades'] = $this->model->getCantidad();
    $data['grupos'] = $this->model->getGrupo();
        $this->views->getView($this, "index", $data);
    }
    public function listaPrestamos()
    {
    $id_ruta = $_SESSION['id_ruta'];
    $data['clientes'] = $this->model->getCliente($id_ruta);
    $data['cantidades'] = $this->model->getCantidad();
    $data['grupos'] = $this->model->getGrupo();
       

        $this->views->getView($this, "listaPrestamos",$data);
    }

    ////////////////////Temporales///////////
    public function listarPrestamoTemp()
    {
        $id_ruta = $_SESSION['id_ruta'];
        date_default_timezone_set('America/Chihuahua');
        setlocale(LC_TIME, 'es_MX');

        $fecharegistro = date('j/n/Y');
        
        $data = $this->model->getPrestamosTemp($id_ruta, $fecharegistro);
        //Se crea un for para crear las acciones de los botones
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['cantidad']='<td>'."$ " .$data[$i]['cantidad'].' </td>';
            $data[$i]['total_pago']='<td>'."$ " .$data[$i]['total_pago'].' </td>';
                $data[$i]['acciones'] = '<div><button class="btn btn-primary" type="button" onclick="btnEditarPrestamo(' . $data[$i]['id'] . ');" ><i class="fas fa-edit"></i></button></div>';

        }

        //Mandamos el JSON a la función JS
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    //////////////Tabla Permantente
    public function listarPrestamo()
    {
        $id_ruta = $_SESSION['id_ruta'];
        $data = $this->model->getPrestamos($id_ruta);
        //Se crea un for para crear las acciones de los botones
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['cantidad']='<td>'."$ " .$data[$i]['cantidad'].' </td>';
            $data[$i]['total_pago']='<td>'."$ " .$data[$i]['total_pago'].' </td>';
            $data[$i]['acciones'] = '<div><button class="btn btn-primary" type="button" onclick="btnEditarPrestamo('.$data[$i]['id'].');" ><i class="fas fa-edit"></i></button>
            <button class="btn btn-success" type="button" onclick="btnPago('.$data[$i]['id_cliente'].');" ><i class="fas fa-dollar"></i></button>
            </div>';
            
        }

        //Mandamos el JSON a la función JS
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }


    public function registrar()
    {
        //Se almacenan los valores que se obtengan por el método Post de los campos de la bd
        $porcentaje = $_POST['porcentaje'];
        $plazo = $_POST['plazo'];
        $cantidad_dia = str_replace("$ ", "", $_POST['cantidad_dia']); // para quitar el símbolo "$"
        $total_pago = str_replace("$ ", "", $_POST['total']);
        $fecha_inicio = $_POST['fecha_inicio'];
        $fecha_final = $_POST['fecha_final'];
        $hora_prestamo = $_POST['hora_prestamo'];
        $id_grupo = $_POST['grupo'];
        $id_cantidad = $_POST['credito'];
        $id_cliente = $_POST['cliente'];
        $id_ruta = $_SESSION['id_ruta'];

        //Se colocó a lo último porque es para poder modificar los clientes
        $id = $_POST['id'];

        
        
        //Se confirma
        if (empty($porcentaje) || empty($plazo) || empty($cantidad_dia) || empty($total_pago) || empty($fecha_inicio) || empty($fecha_final) || empty($id_grupo) || empty($id_cantidad) || empty($id_cliente)) {
            //Se crea un mensaje. Para ello se crea una variable
            $msg = "Todos los campos son obligatorios";
        } else {
            
            //Se verifica si id es igual a vacío, se hace la insersección de datos.
            if ($id == "") {
                //Se crea una variable que accede al modelo y se manda a llamar al método registrarUsuarios junto con sus parámetros en el modelo
                $data = $this->model->registrarPrestamos($porcentaje, $plazo, $cantidad_dia, $total_pago, $fecha_inicio, $fecha_final, $hora_prestamo, $id_grupo, $id_cantidad, $id_cliente, $id_ruta);
                $saldo_vencido = 0;
                $fecha_saldo = $fecha_inicio;
                
                $data = $this->model->registrarSaldo($total_pago, $saldo_vencido, $fecha_saldo, $id_cliente); //Este $id es del $id_prestamo
                //Se hace la verificación
                if ($data == "ok") {
                    $msg = "si";
                    //Verficación de usuario existente. Viene del modelo usuario
                } else if ($data == "existe") {
                    $msg = "El Prestamo ya existe";
                } else {
                    $msg = "Error al registrar prestamo";
                }
            } else {
                
                $saldo = $_POST['saldo'];
                if($saldo == ""){
                    date_default_timezone_set('America/Chihuahua');
                setlocale(LC_TIME, 'es_MX');

                $fecharegistro = date('j/n/Y');
                //Se crea una variable que accede al modelo y se manda a llamar al método modificarUsuarios junto con sus parámetros en el modelo
                $data = $this->model->modificarPrestamos($porcentaje, $plazo, $cantidad_dia, $total_pago, $fecharegistro, $fecha_final, $hora_prestamo, $id_grupo, $id_cantidad, $id_cliente, $id_ruta, $id);
                $saldo_vencido = 0;
                $fecha_saldo = $fecha_inicio;
                $data = $this->model->modificarSaldo($total_pago, $saldo_vencido, $fecha_saldo, $id_cliente);
                }
                
                  //Se hace la verificación
                if ($data == "modificado") {
                    $msg = "modificado";
                } else {
                    $msg = "Error al modificar prestamo";
                }
            }
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function registrarPagosAdelanto()
    {
        //Se almacenan los valores que se obtengan por el método Post de los campos de la bd

        $pago = $_POST['pago']; //Pagos
        $tipo_pago = $_POST['tipo_pago']; //Pagos
        $saldo = $_POST['saldo1'];
        
        $fecha_pago = $_POST['fecha_pago']; // Pagos
        $hora_pago = $_POST['hora_pago']; // Pagos
        $id_grupo = $_POST['id_grupo']; //Pagos
        $id_cliente = $_POST['id_cliente']; // Pagos
        $id_prestamo = $_POST['id_prestamo']; //Pagos
        $id_ruta = $_SESSION['id_ruta']; //Pagos
        $saldo_vencido = $_POST['saldo_vencido'];
        
        //Se confirma
        if (empty($pago) || empty($tipo_pago) || empty($fecha_pago) || empty($hora_pago) || empty($id_grupo) || empty($id_prestamo) || empty($id_cliente) || empty($id_ruta)) {
            //Se crea un mensaje. Para ello se crea una variable
            $msg = "Todos los campos son obligatorios";
        } else {
            $cuotas_vencidas = 0; //Pagos
            $dias_atraso = 0; // Pagos
            
                //Se crea una variable que accede al modelo y se manda a llamar al método registrarUsuarios junto con sus parámetros en el modelo
                $data = $this->model->registrarPago($pago, $tipo_pago, $cuotas_vencidas, $dias_atraso, $fecha_pago, $hora_pago, $id_grupo, $id_cliente, $id_prestamo, $id_ruta);
                $saldo_actual= $saldo - $pago;
                $saldo_vencido_actual = $saldo_vencido + $pago;
                $data = $this->model->actualizarSaldo($saldo_actual, $saldo_vencido_actual, $fecha_pago, $id_cliente);
                //Se hace la verificación
                if ($data == "ok") {
                    $msg = "si";
                    //Verficación de usuario existente. Viene del modelo usuario
                } else if ($data == "existe") {
                    $msg = "El Pago ya existe";
                } else {
                    $msg = "Error al registrar pago";
                }
            
        }
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        die();
    }

    //Aquí se crea la función de editar indicando como parámetro que recibe un entero para que se ejecute en el index de Views/Usuarios
    public function editar(int $id)
    {
        //Se crea una ariable donde almacena el acceso al modelo usuario (UsuariosModel) llamando al método editarUser() indicando que recibe un parámetro entero, en este caso $id
        $data = $this->model->editarPrestamo($id);

        //Se visualiza con un echo y un JSON, donde el JSON_UNESCAPED_UNICODE es para no tener problemas con los acentos
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }
    
    public function infoCliente(int $id)
    {
        //Se crea una ariable donde almacena el acceso al modelo usuario (UsuariosModel) llamando al método editarUser() indicando que recibe un parámetro entero, en este caso $id
        $data = $this->model->infoClientes($id);

        //Se visualiza con un echo y un JSON, donde el JSON_UNESCAPED_UNICODE es para no tener problemas con los acentos
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    //Aquí se crea la función de eliminar indicando como parámetro que recibe dos enteros para que se ejecute en el index de Views/Usuarios
    public function eliminar(int $id)
    {
        //Se crea una variable donde almacena el acceso al modelo usuario (UsuariosModel) llamando al método eeliminarUser() indicando que recibe dos parámetro un 0 y un entero, en este caso 0 y $id
        $data = $this->model->accionPrestamo(0, $id);
        

        //Se hace una validación
        if ($data == 1) {
            $msg = "ok";
        } else {
            $msg = "Error al cambiar el estado del prestamo";
        }
        //Se visualiza con un echo y un JSON, donde el JSON_UNESCAPED_UNICODE es para no tener problemas con los acentos
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        //Elimina el proceso
        die();
    }

    //Aquí se crea la función de reingresar indicando como parámetro que recibe un entero para que se ejecute en el index de Views/Usuarios
    public function reingresar(int $id)
    {
        //Se crea una ariable donde almacena el acceso al modelo usuario (UsuariosModel) llamando al método eeliminarUser() indicando que recibe dos parámetros, en este caso 1 para cambiar el estado y $id
        $data = $this->model->accionPrestamo(1, $id);

        //Se hace una validación
        if ($data == 1) {
            $msg = "ok";
        } else {
            $msg = "Error al cambiar el estado del prestamo";
        }
        //Se visualiza con un echo y un JSON, donde el JSON_UNESCAPED_UNICODE es para no tener problemas con los acentos
        echo json_encode($msg, JSON_UNESCAPED_UNICODE);
        //Elimina el proceso
        die();
    }

    //Aquí se crea la función de salir para que se ejecute en el index de Views/Usuarios
    public function salir()
    {
        //Se destruye las sesiones
        session_destroy();

        //Se le agrega el header y dentro se le coloca la locación concatenada con la constante base_url, para que lo mande al login o index principal, es decir, que que ingrese de nueo sesión
        header("location: " . base_url);
    }
}
