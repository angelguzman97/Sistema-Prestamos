<?php class PagosModel extends Query{
     //Se crean los parámetros que irán dentro de la función registrarUsuarios()
     private $id_cliente, $id_ruta, $id, $abono, $fecha_pago, $hora_pago, $id_prestamo, $pago, $saldo, $dias_atraso, $saldo_vencido, $fecha_saldo, $cuotas_vencidas, $tipo_pago, $id_grupo, $fechaH;
     //Se crean los parámetros que irán dentro de la función editarUser()
 
     public function __construct()
     {
         parent::__construct();
     }

     public function getClientesPrestamos(int $id_ruta, string $fecha_actual)
     {
         
         date_default_timezone_set('America/Chihuahua');
        setlocale(LC_TIME, 'es_MX');

        $fecha_actual = date('Y-m-d');
        
       // (STR_TO_DATE(p.fecha_pago, '%d/%m/%Y') >= '$fecha_actual')
        
        $sql = "SELECT cl.*, pr.*, g.*,
        cl.id AS id_cliente,
        pr.id AS id_prestamo,
        g.id AS id_grupo,
        s.id AS id_saldo,
        p.id AS id_pago,
        s.saldo, s.saldo_vencido, g.grupo,
        COALESCE(dias_atraso, 0) AS dias_atraso,
        COALESCE(cuotas_vencidas, 0) AS cuotas_vencidas,
        SUM(p.dias_atraso),
        SUM(p.cuotas_vencidas)
        FROM clientes cl 
        INNER JOIN prestamos pr ON pr.id_cliente = cl.id INNER JOIN grupos g ON pr.id_grupo = g.id
        INNER JOIN saldos s ON s.id_cliente = cl.id AND (STR_TO_DATE(s.fecha_saldo, '%d/%m/%Y') != '$fecha_actual') and (STR_TO_DATE(s.fecha_saldo, '%d/%m/%Y') <= '$fecha_actual') AND s.saldo >0
        LEFT JOIN pagos p ON p.id_cliente = cl.id
        WHERE pr.id_ruta = $id_ruta
        GROUP BY cl.id ORDER BY pr.id_grupo ASC";
         $data = $this->selectAll($sql);
         return $data;
     }

    public function registrarPago(int $pago, string $tipo_pago, int $cuotas_vencidas, int $dias_atraso, string $fecha_pago, string $hora_pago, int $id_grupo, int $id_cliente, int $id_prestamo, int $id_ruta)
     {
         date_default_timezone_set('America/Mexico_City');
        //$fecha_hoy = date('Y-m-d');  // Asignar la fecha actual a la variable $fecha_hoy

        $this->pago = $pago;
        $this->tipo_pago = $tipo_pago;
        $this->cuotas_vencidas = $cuotas_vencidas;
        $this->dias_atraso = $dias_atraso;
        $this->fecha_pago = $fecha_pago;
        $this->hora_pago= $hora_pago;
        //$this->fecha_hoy =date('Y-m-d'); 
        $this->id_grupo = $id_grupo;
        $this->id_cliente = $id_cliente;
       // $this->id_prestamo = "";
        $this->id_ruta = $id_ruta;
            //Se crea una variable sql donde se hace la consulta
            $sql = "INSERT INTO pagos(pago, tipo_pago, cuotas_vencidas, dias_atraso, fecha_pago, hora_pago, id_grupo, id_cliente, id_ruta) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)";

            //Se crea una variable que contiene el array donde indicamos las variables creadas con los this y esa variable se enviará a la carpeta config/App/Query.php
            $datos = array($this->pago, $this->tipo_pago, $this->cuotas_vencidas, $this->dias_atraso, $this->fecha_pago, $this->hora_pago, $this->id_grupo, $this->id_cliente, $this->id_ruta);

            //Accedemos o se llama a la función o método saveUser del Query
            $data = $this->save($sql, $datos);

            //Se hace la comprobación de guardar los registros
            if ($data == 1) {
                $res = "ok";
            } else {
                $res = "error";
            }
        return $res;
    }

    public function actualizarSaldo(int $saldo, int $saldo_vencido, string $fecha_saldo, int $id_cliente)
    {
        $this->id_cliente = $id_cliente;
         $this->saldo = $saldo;
         $this->saldo_vencido = $saldo_vencido;
         $this->fecha_saldo = $fecha_saldo;
         //Se crea una variable sql donde se hace la consulta de actualizar los datos. Actualiza de la tabla trabajadores los campos
         $sql = "UPDATE saldos SET saldo = ?, saldo_vencido = ?, fecha_saldo = ? WHERE id_cliente = ?";
 
         //Se crea una variable que contiene el array donde indicamos las variables creadas con los this y esa variable se enviará a la carpeta config/App/Query.php
         $datos = array($this->saldo, $this->saldo_vencido, $this->fecha_saldo, $this->id_cliente);

         //Accedemos o se llama a la función o método saveUser del Query
         $data = $this->save($sql, $datos);
         if ($data == 1) {
            $res = "ok";
        } else {
            $res = "error";
        }
    return $res;
    }


    public function getPagos(int $id_ruta)
    {
       $sql = "SELECT cl.*, pr.*,
       cl.id AS id_cliente,
       pr.id AS id_prestamo,
       s.id AS id_saldo,
       s.saldo,
       p.id AS id_pago,
       s.saldo, s.saldo_vencido,
       COALESCE(dias_atraso, 0) AS dias_atraso,
       COALESCE(cuotas_vencidas, 0) AS cuotas_vencidas,
       SUM(p.dias_atraso) AS atraso,
       SUM(p.cuotas_vencidas) AS cuotas
       FROM clientes cl 
       INNER JOIN prestamos pr ON pr.id_cliente = cl.id 
       INNER JOIN saldos s ON s.id_cliente = cl.id
       LEFT JOIN pagos p ON p.id_cliente = cl.id
       WHERE pr.id_ruta = $id_ruta
       GROUP BY cl.id";
        $data = $this->selectAll($sql);
        return $data;
    }
    public function getPagosHoy(int $id_ruta)
    {

        date_default_timezone_set('America/Chihuahua');
        setlocale(LC_TIME, 'es_MX');

        $fecha_actual = date('Y-n-j');


       $sql = "SELECT cl.*, pr.*, p.*,
       cl.id AS id_cliente,
       pr.id AS id_prestamo,
       s.id AS id_saldo,
       s.saldo,
       p.id AS id_pago,
       s.saldo_vencido, s.fecha_saldo,
       COALESCE(dias_atraso, 0) AS dias_atraso,
       COALESCE(cuotas_vencidas, 0) AS cuotas_vencidas,
       SUM(p.pago) AS pagos,
       SUM(p.dias_atraso) AS atraso,
       SUM(p.cuotas_vencidas) AS cuotas
       FROM clientes cl 
       INNER JOIN prestamos pr ON pr.id_cliente = cl.id 
       INNER JOIN saldos s ON s.id_cliente = cl.id
       LEFT JOIN pagos p ON p.id_cliente = cl.id 
       WHERE pr.id_ruta = $id_ruta AND (STR_TO_DATE(p.fecha_hoy, '%Y-%m-%d') = '$fecha_actual')";
        $data = $this->selectAll($sql);
        return $data;
    }

     //Se crea una función del botón editar usuarios y poder visualizarlo en el index, donde indicamos 1 parámetro de tipo int que vienen del controlador usuarios
     public function getPagosClientesG(int $id)
     {
         //Se crea una variable sql donde almacena la consulta a la bd.
         // Selecciona toda la tabla de trabajadores donde el id sea igual al parametro $id   
         $sql = "SELECT * FROM pagos WHERE id_cliente = $id ORDER BY id DESC";
 
         //Se crea una variable donde almacena el llamado al método select() donde se obtiene un solo dato y se le pasa a la variable $sql
         $data = $this->selectAll($sql);
 
         //Se retorna la variable
         return $data;
     }

}
?>