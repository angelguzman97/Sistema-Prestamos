<?php class CuadresG extends Controller{
  //Este constructor se hace igual en el controlador home
  public function __construct()
  {
      //Esto inicializa las sesiones
      session_start();

      //Se verifica si no se tiene una sesión activa. empty es Si no existe
      if (empty($_SESSION['activo'])) {
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
  
  public function listaCuadres()
  {
        
    $this->views->getView($this, "listaCuadres");
      
  }


  public function cuadreSemanal(int $id)
  {
        
    $data['tabla'] = $this->model->getCuadreTabla($id);       
    $data['tabla2'] = $this->model->getCuadresG($id); 

    //Mandamos el JSON a la función JS
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    die();
        
  }
  
  public function historialSemanal(int $id)
  {
        
    $data = $this->model->getHistorialSemanal($id); 

    //Mandamos el JSON a la función JS
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    die();
        
  }


  public function registrarCuadreSemanal()
  {
    $total_abonos = $_POST['total_abonos'];
    $total_ventas = $_POST['total_ventas'];
    $total_gastos = $_POST['total_gastos'];
    $caja_semanal = $_POST['caja_semanal'];
    $fecha_semanal = $_POST['fecha_semanal'];
    $id_ruta = $_POST['id_ruta'];
    $id = $_POST['id'];
  

        //Se confirma
        if ( empty($total_abonos) || empty($total_ventas) || empty($total_gastos) || empty($id_ruta)) {
            /*empty($caja_semanal)|| */
          //Se crea un mensaje. Para ello se crea una variable
          $msg = "Todos los campos son obligatorios";
      } else {
          
          //Se verifica si id es igual a vacío, se hace la insersección de datos.
          if ($id == "") {
              //Se crea una variable que accede al modelo y se manda a llamar al método registrarUsuarios junto con sus parámetros en el modelo
              $data = $this->model->registrarCuadresSemanales($total_abonos, $total_ventas, $total_gastos, $caja_semanal, $fecha_semanal, $id_ruta);
              $vaciarCuadreSemanal = $this->model->vaciarCuadresSemanales($id_ruta);
              if ($data == "ok") {
                  $msg = "si";
                  //Verficación de usuario existente. Viene del modelo usuario
              } else if ($data == "existe") {
                  $msg = "El cuadre semanal ya existe";
              } else {
                  $msg = "Error al registrar cuadre semanal";
              }
          }
      }
      echo json_encode($msg, JSON_UNESCAPED_UNICODE);
      die();
   }

  public function listaPagos()
  {
      $this->views->getView($this,"listaPagos");
  }


  public function pagosHoy()
  {
      $this->views->getView($this,"pagoHoy");
  }

  public function listarPagoHoy()
  {
      $id_ruta = $_SESSION['id_ruta'];
      date_default_timezone_set('America/Chihuahua');
        setlocale(LC_TIME, 'es_MX');

        $fecha_actual = date('j/n/Y');
      $data = $this->model->getPagosHoy($id_ruta);
      for ($i = 0; $i < count($data); $i++) {
        $data[$i]['total_pago']='<td>'."$" .$data[$i]['total_pago'].' </td>';
        $data[$i]['saldo']='<td>'."$" .$data[$i]['saldo'].' </td>';

        if ($data[$i]['fecha_saldo'] == $fecha_actual & $data[$i]['pago'] >= $data[$i]['cantidad_dias']) {
          $data[$i]['fecha_saldo']='<span class= "badge bg-success">Pagado</span>';
        }else if($data[$i]['fecha_saldo'] == $fecha_actual & $data[$i]['pago'] != 0) {
          $data[$i]['fecha_saldo']='<span class= "badge bg-warning">Abonado</span>';
        }else {
          $data[$i]['fecha_saldo']='<span class= "badge bg-danger">Cuota</span>';
        }
        
      }
      //Se crea un for para crear las acciones de los botones
      echo json_encode($data, JSON_UNESCAPED_UNICODE);
      die(); 
  }

  
}
