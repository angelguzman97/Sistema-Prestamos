<?php class CuadresGModel extends Query{
     //Se crean los parámetros que irán dentro de la función registrarUsuarios()
     private $total_abonos, $total_ventas, $total_gastos, $caja_semanal, $fecha_semanal, $id_ruta, $id;
     //Se crean los parámetros que irán dentro de la función editarUser()
 
     public function __construct()
     {
         parent::__construct();
     }

     public function getCuadreTabla(int $id)
     {
         // Selecciona toda la tabla de trabajadores donde el id sea igual al parametro $id   
         $sql = "SELECT * FROM cuadre_stemporal WHERE id_ruta = $id";
 
         //Se crea una variable donde almacena el llamado al método select() donde se obtiene un solo dato y se le pasa a la variable $sql
         $data = $this->selectAll($sql);
 
         //Se retorna la variable
         return $data;
     }
     

     public function getCuadresG(int $id)
     {
         // Selecciona toda la tabla de trabajadores donde el id sea igual al parametro $id   
         $sql = "SELECT SUM(cobrado) AS abonos,
         SUM(prestamos) AS ventas,
         SUM(gastos) AS gastos,
         SUM(inversion) AS inversion ,id_ruta, caja_final
         FROM cuadre_stemporal WHERE id_ruta = $id";
 
         //Se crea una variable donde almacena el llamado al método select() donde se obtiene un solo dato y se le pasa a la variable $sql
         $data = $this->select($sql);
 
         //Se retorna la variable
         return $data;
     }

     public function getTablasRutas(int $id_ruta)
    {      //Al c.id se le coloca un alias ara que no muetre el id de las cajas, sino del id del trabajador 
        $sql = "SELECT * FROM rutas WHERE id != $id_ruta";
        //Accedemos o se llama a la función o método select del Query
        $listarR = $this->selectAll($sql);
        return $listarR;
    }
    
    public function getHistorialSemanal(int $id_ruta)
   {      //Al c.id se le coloca un alias ara que no muetre el id de las cajas, sino del id del trabajador 
       $sql = "SELECT * FROM cuadres_semanales WHERE id_ruta = $id_ruta ORDER BY id DESC";
       //Accedemos o se llama a la función o método select del Query
       $listarR = $this->selectAll($sql);
       return $listarR;
   }

     public function registrarCuadresSemanales(int $total_abonos, int $total_ventas, int $total_gastos, int $caja_semanal, string $fecha_semanal, int $id_ruta)
     {
        $this->total_abonos = $total_abonos;
        $this->total_ventas = $total_ventas;
        $this->total_gastos = $total_gastos;
        $this->caja_semanal = $caja_semanal;
        $this->fecha_semanal = $fecha_semanal;
        $this->id_ruta = $id_ruta;
       

//fecha_semanal = '$fecha_semanal'
        $verificar = "SELECT * FROM cuadres_semanales WHERE id = 0 ";
        //Se ejecuta trayendo el método select que ya se tiene creado como parámetro se le pasa el parámetro $verificar y todo eso se almacena en una variable.
        $existe = $this->select($verificar);
        //Se erifica con un if. Si existe se hace la consulta
        if (empty($existe)) {
            //Se crea una variable sql donde se hace la consulta
            $sql = "INSERT INTO cuadres_semanales(total_abonos, total_ventas, total_gastos, caja_semanal, fecha_semanal, id_ruta) VALUES(?, ?, ?, ?, ?, ?)";

            //Se crea una variable que contiene el array donde indicamos las variables creadas con los this y esa variable se enviará a la carpeta config/App/Query.php
            $datos = array($this->total_abonos, $this->total_ventas, $this->total_gastos, $this->caja_semanal, $this->fecha_semanal, $this->id_ruta);

            //Accedemos o se llama a la función o método saveUser del Query
            $data = $this->save($sql, $datos);

            //Se hace la comprobación de guardar los registros
            if ($data == 1) {
                $res = "ok";
            } else {
                $res = "error";
            }
        }else {
            $res = "existe";
        }
        return $res;
    }
public function vaciarCuadresSemanales(int $id_ruta)
    {
        $sql ="DELETE FROM cuadre_stemporal WHERE id_ruta = ?";
       $datos = array($id_ruta);
       $data = $this->save($sql, $datos);
       
       if ($data == 1) {
            $res = "ok";
        }else{
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

        $fecha_actual = date('j/n/Y');

       $sql = "SELECT cl.*, pr.*, p.*,
       cl.id AS id_cliente,
       pr.id AS id_prestamo,
       s.id AS id_saldo,
       s.saldo,
       p.id AS id_pago,
       s.saldo, s.saldo_vencido, s.fecha_saldo,
       COALESCE(dias_atraso, 0) AS dias_atraso,
       COALESCE(cuotas_vencidas, 0) AS cuotas_vencidas,
       SUM(p.dias_atraso) AS atraso,
       SUM(p.cuotas_vencidas) AS cuotas
       FROM clientes cl 
       INNER JOIN prestamos pr ON pr.id_cliente = cl.id 
       INNER JOIN saldos s ON s.id_cliente = cl.id
       LEFT JOIN pagos p ON p.id_cliente = cl.id 
       WHERE pr.id_ruta = $id_ruta AND p.fecha_pago = '$fecha_actual'
       GROUP BY cl.id";
        $data = $this->selectAll($sql);
        return $data;
    }

    

}
?>