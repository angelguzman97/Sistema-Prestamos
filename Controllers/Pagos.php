<?php class Pagos extends Controller{
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
  
  public function vistaPagos()
  {
    date_default_timezone_set('America/Chihuahua');
        setlocale(LC_TIME, 'es_MX');

        $fecha_actual = date('j/n/Y');

    $id_ruta= $_SESSION['id_ruta'];
    $data= $this->model->getClientesPrestamos($id_ruta, $fecha_actual);
    
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    die();
  }

  public function registrarPago()
  {
      $fecha_final = $_POST['fecha_final']; //Fecha final del préstamo
      $pago = $_POST['cantidad_dias']; //Pagos
      $abono = $_POST['abono']; //Pagos
      $tipo_pago = $_POST['tipo_pago']; //Pagos
      $saldo = $_POST['saldo'];
      $cuotas_vencidas = $_POST['cuotas_vencidas']; //Pagos
      $dias_atraso = $_POST['dias_atraso']; // Pagos
      $fecha_pago = $_POST['fecha_pago']; // Fecha de los Pagos
      $hora_pago = $_POST['hora_pago']; // Pagos
      $id_grupo = $_POST['id_grupo']; //Pagos
      $id_cliente = $_POST['id_cliente']; // Pagos
      $id_prestamo = $_POST['id_prestamo']; //Pagos
      $id_ruta = $_SESSION['id_ruta']; //Pagos
      $saldo_vencido = $_POST['saldo_vencido'];
       
      if (empty($abono)) {
        $abono = 0;
        $cuotas_vencidas =0;

date_default_timezone_set('America/Chihuahua');
        setlocale(LC_TIME, 'es_MX');

        $fecha_actual = date('j/n/Y');
        
        if ($fecha_final < $fecha_actual) {
          $dias_atraso = 1;
        }else{
          $dias_atraso = 0;
        }

        $data = $this->model->registrarPago($pago, $tipo_pago, $cuotas_vencidas, $dias_atraso, $fecha_pago, $hora_pago, $id_grupo, $id_cliente, $id_prestamo, $id_ruta);
        $saldo_actual = $_POST['saldo'] - $pago;
        $saldo_vencido_actual = $saldo_vencido + $pago;
        $data = $this->model->actualizarSaldo($saldo_actual, $saldo_vencido_actual, $fecha_pago, $id_cliente);
                
      }else{
        $pago = 0;
        $cuotas_vencidas =0;

        if ($fecha_final < $fecha_actual) {
          $dias_atraso = 1;
        }else{
          $dias_atraso = 0;
        }

        $data = $this->model->registrarPago($abono, $tipo_pago, $cuotas_vencidas, $dias_atraso, $fecha_pago, $hora_pago, $id_grupo, $id_cliente, $id_prestamo, $id_ruta);
        $saldo_actual = $_POST['saldo'] - $abono;
        $saldo_vencido_actual = $saldo_vencido + $abono;
       $data = $this->model->actualizarSaldo($saldo_actual, $saldo_vencido_actual, $fecha_pago, $id_cliente);
       

      }
     

      if ($data == "ok") {
        $response = array('msg' => 'si');
      } else {
        $response = array('msg' => 'Error al registrar pago');
      }
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
        die();
   }


   public function registrarCuota()
   {
       $fecha_final = $_POST['fecha_final']; //Fecha final del préstamo
       $pago = $_POST['cantidad_dias'];
       $abono = $_POST['abono'];
       $tipo_pago = $_POST['tipo_pago'];
       $saldo = $_POST['saldo'];
       $cuotas_vencidas = $_POST['cuotas_vencidas'];
       $saldo_vencido = $_POST['saldo_vencido'];
       $fecha_pago = $_POST['fecha_pago'];
       $hora_pago = $_POST['hora_pago'];
       $dias_atraso = $_POST['dias_atraso'];
       $id_grupo = $_POST['id_grupo'];
       $id_cliente = $_POST['id_cliente'];
       $id_prestamo = $_POST['id_prestamo'];
       $id_ruta = $_SESSION['id_ruta'];
       
       if (empty($abono) || empty($pago)) {
        
        $pago = 0;
        $abono = 0;
        $tipo_pago = "N/P";
        $cuotas_vencidas =1;
        
        date_default_timezone_set('America/Chihuahua');
        setlocale(LC_TIME, 'es_MX');

        $fecha_actual = date('j/n/Y');
        $fechaH = date('Y-m-d');
        
        if ($fecha_final < $fecha_actual) {
          $dias_atraso = 1;
        }else{
          $dias_atraso = 0;
        }
        
        $data = $this->model->registrarPago($pago, $tipo_pago, $cuotas_vencidas, $dias_atraso, $fecha_pago, $hora_pago, $id_grupo, $id_cliente, $id_prestamo, $id_ruta);
        $saldo_actual = $saldo;
        $saldo_vencido_actual = $saldo_vencido;
        $data = $this->model->actualizarSaldo($saldo_actual, $saldo_vencido_actual, $fecha_pago, $id_cliente);
        
      }
       
 
       if ($data == "ok") {
         $response = array('msg' => 'si');
       } else {
         $response = array('msg' => 'Error al registrar pago');
       }
         echo json_encode($response, JSON_UNESCAPED_UNICODE);
         die();
  }

  public function listaPagos()
  {
      $this->views->getView($this,"listaPagos");
  }

  public function listarPago()
  {
      $id_ruta = $_SESSION['id_ruta'];
      $data = $this->model->getPagos($id_ruta);
      for ($i = 0; $i < count($data); $i++) {
        $data[$i]['total_pago']='<td>'."$" .$data[$i]['total_pago'].' </td>';
        $data[$i]['saldo']='<td>'."$" .$data[$i]['saldo'].' </td>';
        $data[$i]['acciones'] = '<button class="btn btn-secondary" type="button" onclick="btnHistorialCliente('.$data[$i]['id_cliente'].');" ><i class="fas fa-history"></i></button></div>';
        
      }
      //Se crea un for para crear las acciones de los botones
      echo json_encode($data, JSON_UNESCAPED_UNICODE);
      die(); 
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
        $data[$i]['pago']='<td>'."$" .$data[$i]['pago'].' </td>';

        if ($data[$i]['fecha_saldo'] == $fecha_actual && $data[$i]['pago'] >= $data[$i]['cantidad_dias']) {
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

  public function histoClientesG($id)
    {
        
        $data = $this->model->getPagosClientesG($id);

        //Mandamos el JSON a la función JS
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
        
    }
}
