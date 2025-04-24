<?php class ReportesModel extends Query{
     //Se crean los parámetros que irán dentro de la función registrarUsuarios()
     private $id_ruta, $id_reporte, $dia_semana, $clientes_programados, $clientes_visitados, $clientes_pendientes, $caja_inicial, $cobrado, $prestamo, $gastos, $tipo_gastos, $inversion, $tipo_inversion, $caja_final, $fecha, $hora,$caja_real, $fecha_reporte, $hora_reporte, $id;
     //Se crean los parámetros que irán dentro de la función editarUser()
 
     public function __construct()
     {
         parent::__construct();
     }

     
     public function getPagosDia(int $id_ruta)
     {
        $sql="SELECT * FROM pagos_dia WHERE id_ruta = $id_ruta";
        $data = $this->selectAll($sql);
        return $data;
     }

     public function getReportes(int $id_ruta)
     {
        $sql="SELECT * FROM reportes WHERE id_ruta = $id_ruta
        ORDER BY id DESC";
        $data = $this->selectAll($sql);
        return $data;
    }

    public function getClientesPrestamos(int $id_ruta)
    {
        date_default_timezone_set('America/Chihuahua');
        setlocale(LC_TIME, 'es_MX');

        $fecha_actual = date('j/n/Y');

        $sql = "SELECT
        c.id AS id_cantidad, c.cantidad,
        pr.id AS id_prestamo,
        SUM(c.cantidad) AS prestamo
        FROM prestamos pr INNER JOIN cantidades c WHERE c.id = pr.id_cantidad AND pr.id_ruta = $id_ruta AND pr.fecha_inicial = '$fecha_actual'";
        $data = $this->selectAll($sql);
        return $data;
    }
    public function getClientesPagos(int $id_ruta)
    {
        date_default_timezone_set('America/Chihuahua');
        setlocale(LC_TIME, 'es_MX');

        $fecha_actual = date('Y-m-d'); //(STR_TO_DATE(p.fecha_hoy, '%Y-%m-%d') >= '$fecha_actual')
        //$fecha_actual = date('j/n/Y');

        $sql = "SELECT
        COUNT(DISTINCT pr.id_cliente) AS programados,
        COUNT(DISTINCT p.id_cliente) AS visitados,
        SUM(p.pago) AS cobrado,
        SUM(p.dias_atraso) AS pendiente,
        r.caja_inicial, r.caja_anterior
        FROM prestamos pr LEFT JOIN pagos p ON p.id_cliente = pr.id_cliente AND (STR_TO_DATE(p.fecha_pago, '%d/%m/%Y') >= '$fecha_actual') INNER JOIN rutas r ON pr.id_ruta = r.id
        WHERE pr.id_ruta = $id_ruta";
        $data = $this->selectAll($sql);
        return $data;
    }

    public function getPrestamosHoy(int $id_ruta)
    {
        date_default_timezone_set('America/Chihuahua');
        setlocale(LC_TIME, 'es_MX');

    $fecha_actual = date('j/n/Y');
    
        $sql="SELECT pr.*, pr.id AS id_prestamo, c.id AS id_cantidad, c.cantidad FROM prestamos pr INNER JOIN cantidades c WHERE c.id = pr.id_cantidad AND pr.id_ruta = $id_ruta AND pr.fecha_inicial = '$fecha_actual";
        $data = $this->selectAll($sql);
        return $data;
    }

    public function registrarPagoRuta(int $clientes_programados, int $clientes_visitados, int $clientes_pendientes, int $caja_inicial, int $cobrado, int $prestamo, int $gastos, string $tipo_gastos, int $inversion, string $tipo_inversion, int $caja_final, string $fecha, string $hora, int $id_ruta)
    {
        $this->clientes_programados= $clientes_programados;
        $this->clientes_visitados= $clientes_visitados;
        $this->clientes_pendientes= $clientes_pendientes;
        $this->caja_inicial= $caja_inicial;
        $this->cobrado= $cobrado;
        $this->prestamo= $prestamo;
        $this->gastos= $gastos;
        $this->tipo_gastos= $tipo_gastos;
        $this->inversion= $inversion;
        $this->tipo_inversion= $tipo_inversion;
        $this->caja_final= $caja_final;
        $this->fecha= $fecha;
        $this->hora= $hora;
        $this->id_ruta= $id_ruta;

          

          $verificar = "SELECT * FROM pagos_dia WHERE id_ruta = '$id_ruta' and fecha = '$fecha'";
        //Se ejecuta trayendo el método select que ya se tiene creado como parámetro se le pasa el parámetro $verificar y todo eso se almacena en una variable.
        $existe = $this->select($verificar);

        if (empty($existe)) {

        //Se crea una variable sql donde se hace la consulta
        $sql = "INSERT INTO pagos_dia(clientes_programados, clientes_visitados, clientes_pendientes, caja_inicial, cobrado, prestamo, gastos, tipo_gastos, inversion, tipo_inversion, caja_final, fecha, hora, id_ruta) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        //Se erifica con un if. Si existe se hace la consulta
          //Se crea una variable que contiene el array donde indicamos las variables creadas con los this y esa variable se enviará a la carpeta config/App/Query.php
          $datos = array($this->clientes_programados, $this->clientes_visitados, $this->clientes_pendientes, $this->caja_inicial, $this->cobrado, $this->prestamo, $this->gastos, $this->tipo_gastos, $this->inversion, $this->tipo_inversion, $this->caja_final, $this->fecha, $this->hora, $this->id_ruta);

          //Accedemos o se llama a la función o método saveUser del Query
          $data = $this->save($sql, $datos);
          //Se hace la comprobación de guardar los registros
          if ($data == 1) {
              $res = "ok";
            } else {
                $res = "error";
            }
        } else {
            $res = "existe";
        }
      return $res;
    }
    
    public function registrarCuadreTmp(int $dia_semana, int $cobrado, int $prestamo, int $gastos, int $inversion, int $caja_final, string $fecha, string $hora, int $id_ruta)
    {
        $this->dia_semana= $dia_semana;
        $this->cobrado= $cobrado;
        $this->prestamo= $prestamo;
        $this->gastos= $gastos;
        $this->inversion= $inversion;
        $this->caja_final= $caja_final;
        $this->fecha= $fecha;
        $this->hora= $hora;
        $this->id_ruta= $id_ruta;

          

          $verificar = "SELECT * FROM cuadre_stemporal WHERE fecha = '$hora'";
        //Se ejecuta trayendo el método select que ya se tiene creado como parámetro se le pasa el parámetro $verificar y todo eso se almacena en una variable.
        $existe = $this->select($verificar);

        if (empty($existe)) {

        //Se crea una variable sql donde se hace la consulta
        $sql = "INSERT INTO cuadre_stemporal(dia, cobrado, prestamos, gastos, inversion, caja_final, fecha, hora, id_ruta) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)";
        //Se erifica con un if. Si existe se hace la consulta
          //Se crea una variable que contiene el array donde indicamos las variables creadas con los this y esa variable se enviará a la carpeta config/App/Query.php
          $datos = array( $this->dia_semana, $this->cobrado, $this->prestamo, $this->gastos, $this->inversion, $this->caja_final, $this->fecha, $this->hora, $this->id_ruta);

          //Accedemos o se llama a la función o método saveUser del Query
          $data = $this->save($sql, $datos);
          //Se hace la comprobación de guardar los registros
          if ($data == 1) {
              $res = "ok";
            } else {
                $res = "error";
            }
        } else {
            $res = "existe";
        }
      return $res;
    }

    public function getPagoRuta(int $id_ruta)
    {
        $sql = "SELECT pd.*, r.id AS id_ruta, r.ruta FROM pagos_dia pd INNER JOIN rutas r ON pd.id_ruta = r.id WHERE pd.id_ruta = $id_ruta";
        $data = $this->selectAll($sql);
        return $data;
    }

    public function cajaReal(int $id_ruta)
    {
        $sql = "SELECT caja_final AS caja_real FROM pagos_dia WHERE id_ruta = $id_ruta";
        $data = $this->select($sql);
        return $data;
    }

    public function registrarCuadre(int $clientes_programados, int $clientes_visitados, int $clientes_pendientes, int $caja_inicial, int $cobrado, int $prestamo, int $gastos, string $tipo_gastos, int $inversion, string $tipo_inversion, int $caja_final, string  $fecha, string $hora, int $id_ruta, int $id_reporte)
    {
        $this->clientes_programados= $clientes_programados;
        $this->clientes_visitados= $clientes_visitados;
        $this->clientes_pendientes= $clientes_pendientes;
        $this->caja_inicial= $caja_inicial;
        $this->cobrado= $cobrado;
        $this->prestamo= $prestamo;
        $this->gastos= $gastos;
        $this->tipo_gastos= $tipo_gastos;
        $this->inversion= $inversion;
        $this->tipo_inversion= $tipo_inversion;
        $this->caja_final= $caja_final;
        $this->fecha= $fecha;
        $this->hora= $hora;
        $this->id_ruta= $id_ruta;
        $this->id_reporte= $id_reporte;

        //Se crea una variable sql donde se hace la consulta
        $sql = "INSERT INTO cuadres(clientes_programados, clientes_visitados, clientes_pendientes, caja_inicial, cobrado, prestamos, gastos, tipo_gastos, inversion, tipo_inversion, caja_final, fecha, hora, id_ruta, id_reporte) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        //Se erifica con un if. Si existe se hace la consulta
          //Se crea una variable que contiene el array donde indicamos las variables creadas con los this y esa variable se enviará a la carpeta config/App/Query.php
          $datos = array($this->clientes_programados, $this->clientes_visitados, $this->clientes_pendientes, $this->caja_inicial, $this->cobrado, $this->prestamo, $this->gastos, $this->tipo_gastos, $this->inversion, $this->tipo_inversion, $this->caja_final, $this->fecha, $this->hora, $this->id_ruta, $this->id_reporte);

          //Accedemos o se llama a la función o método saveUser del Query
          $data = $this->save($sql, $datos);
          //Se hace la comprobación de guardar los registros
          if ($data == 1) {
            $msg = "ok";
        }else{
            $msg = "Error";
        }
        return $msg;
    }

    //Se crea una función de modificar usuarios (btn modificar), donde indicamos 4 parámetros que vienen del controlador usuarios
    public function cajaAnterior(int $caja_final, string $fecha,int $id_ruta)
    {

        $this->caja_final= $caja_final; 
        $this->fecha= $fecha; 
        $this->id_ruta = $id_ruta;
        $verificar = "SELECT * FROM rutas WHERE fecha_ruta = '$fecha' AND id = '$id_ruta'";
        //Se ejecuta trayendo el método select que ya se tiene creado como parámetro se le pasa el parámetro $verificar y todo eso se almacena en una variable.
        $existe = $this->select($verificar);

        if (empty($existe)) {
   
        //Se crea una variable sql donde se hace la consulta de actualizar los datos. Actualiza de la tabla trabajadores los campos
        $sql = "UPDATE rutas SET caja_anterior = ?, fecha_ruta = ? WHERE  id= ?";

        //Se crea una variable que contiene el array donde indicamos las variables creadas con los this y esa variable se enviará a la carpeta config/App/Query.php
        $datos = array($this->caja_final, $this->fecha, $this->id_ruta);

        //Accedemos o se llama a la función o método saveUser del Query
        $data = $this->save($sql, $datos);

        //Se hace la comprobación de guardar los registros
        if ($data == 1) {
            $res = "ok";
        } else {
            $res = "error";
        }
        } else {
        $res = "existe";
        }
        return $res;
    
    }

    public function registrarReporteRuta(int $caja_real, string $fecha_reporte, string $hora_reporte, int $id_ruta)
    {
        $this->caja_real= $caja_real;
        $this->fecha_reporte= $fecha_reporte;
        $this->hora_reporte= $hora_reporte;
        $this->id_ruta= $id_ruta;

        //Se crea una variable sql donde se hace la consulta
        $sql = "INSERT INTO reportes(caja_real, fecha_reporte, hora_reporte, id_ruta) VALUES(?, ?, ?, ?)";
        //Se erifica con un if. Si existe se hace la consulta
          //Se crea una variable que contiene el array donde indicamos las variables creadas con los this y esa variable se enviará a la carpeta config/App/Query.php
          $datos = array($this->caja_real, $this->fecha_reporte, $this->hora_reporte, $this->id_ruta);

          //Accedemos o se llama a la función o método saveUser del Query
          $data = $this->save($sql, $datos);
          //Se hace la comprobación de guardar los registros
          if ($data == 1) {
            $msg = "ok";
        }else{
            $msg = "Error";
        }
        return $msg;
    }

    public function id_reporte()
    {   //Se obtiene el máximo de id que hay. Y se le coloca un ALIAS
        $sql = "SELECT MAX(id) AS id FROM reportes";
        $data = $this->select($sql);
        return $data;
    }

    public function vaciarPagoDia(int $id_ruta)
    {
        $sql ="DELETE FROM pagos_dia WHERE id_ruta = ?";
       $datos = array($id_ruta);
       $data = $this->save($sql, $datos);
       
       if ($data == 1) {
            $res = "ok";
        }else{
            $res = "error";
        }
        return $res;
    }

    //Se crea una función de modificar usuarios (btn modificar), donde indicamos 4 parámetros que vienen del controlador usuarios
    public function modificarReporte(int $gastos, string $tipo_gastos, int $inversion, string $tipo_inversion, int $id_ruta, int $id)
     {
        
        $this->gastos= $gastos;
        $this->tipo_gastos= $tipo_gastos;
        $this->inversion= $inversion;
        $this->tipo_inversion= $tipo_inversion;
        $this->id_ruta = $id_ruta;
        $this->id = $id;
         
         //Se crea una variable sql donde se hace la consulta de actualizar los datos. Actualiza de la tabla trabajadores los campos
         $sql = "UPDATE pagos_dia SET gastos = ?, tipo_gastos = ?, inversion = ?, tipo_inversion = ? WHERE id_ruta = ? AND id= ?";
 
         //Se crea una variable que contiene el array donde indicamos las variables creadas con los this y esa variable se enviará a la carpeta config/App/Query.php
         $datos = array($this->gastos, $this->tipo_gastos, $this->inversion, $this->tipo_inversion, $this->id_ruta, $this->id);

         //Accedemos o se llama a la función o método saveUser del Query
         $data = $this->save($sql, $datos);

         //Se hace la comprobación de guardar los registros
         if ($data == 1) {
             $res = "modificado";
         } else {
             $res = "error";
         }
         return $res;
    }

     //Se crea una función del botón editar usuarios y poder visualizarlo en el index, donde indicamos 1 parámetro de tipo int que vienen del controlador usuarios
     public function editarReporte(int $id)
     {
         //Se crea una variable sql donde almacena la consulta a la bd.
         // Selecciona toda la tabla de trabajadores donde el id sea igual al parametro $id   
         $sql = "SELECT * FROM pagos_dia WHERE id = $id";
 
         //Se crea una variable donde almacena el llamado al método select() donde se obtiene un solo dato y se le pasa a la variable $sql
         $data = $this->select($sql);
 
         //Se retorna la variable
         return $data;
     }
     
     
     public function getReporte(int $id_reporte)
     {
        $sql = "SELECT rp.*, rp.id AS id_reporte, r.id AS id_ruta, r.ruta, r.caja_anterior, cu.*, cu.id AS id_cuadre FROM reportes rp INNER JOIN rutas r ON rp.id_ruta = r.id INNER JOIN cuadres cu ON rp.id= cu.id_reporte WHERE rp.id = $id_reporte";
        $data = $this->select($sql);
        return $data;
     }

    }
    ?>