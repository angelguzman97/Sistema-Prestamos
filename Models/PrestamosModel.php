<?php
class PrestamosModel extends Query
{
    //Se crean los parámetros que irán dentro de la función registrarUsuarios()
    private $porcentaje, $plazo, $cantidad_dia, $total_pago, $fecha_inicio, $fecha_final, $hora_prestamo, $fecha_saldo, $estado, $id_cantidad, $id_cliente, $id_ruta, $id, $id_grupo, $saldo, $saldo_vencido, $pago, $tipo_pago, $cuotas_vencidas, $dias_atraso, $fecha_pago, $hora_pago, $id_prestamo;
    //Se crean los parámetros que irán dentro de la función editarUser()

    public function __construct()
    {
        parent::__construct();
    }
    //Consulta para mostrar los clientes disponibles
    public function getCliente(int $id_ruta)
    {
        $sql = "SELECT * FROM clientes WHERE id_ruta = $id_ruta AND estado = 1";
        $data = $this->selectAll($sql);
        return $data;
    }
    // Consulta en la tabla de cantidades disponibles
    public function getCantidad()
    {
        $sql = "SELECT * FROM cantidades WHERE estado = 1";
        $data = $this->selectAll($sql);
        return $data;
    }
    // Consulta en la tabla de grupos disponibles
    public function getGrupo()
    {
        $sql = "SELECT * FROM grupos WHERE estado = 1";
        $data = $this->selectAll($sql);
        return $data;
    }

    //Función para mostrar la lista de los usuarios
    public function getPrestamosTemp(int $id_ruta, string $fecharegistro)
    { 
        //Al c.id se le coloca un alias ara que no muetre el id de las cajas, sino del id del trabajador 
        $sql = "SELECT p.*, c.id AS id_cantidad, c.cantidad, cl.id AS id_cliente, cl.cliente FROM prestamos p INNER JOIN cantidades c ON p.id_cantidad = c.id INNER JOIN clientes cl ON p.id_cliente = cl.id WHERE p.id_ruta = $id_ruta AND p.fecha_inicial = '$fecharegistro'";
        //Accedemos o se llama a la función o método select del Query
        $data = $this->selectAll($sql);
        return $data;
    }
    //Función para mostrar la lista de los usuarios
    public function getPrestamos(int $id_ruta)
    {  
        
       //Al c.id se le coloca un alias ara que no muetre el id de las cajas, sino del id del trabajador 
        $sql = "SELECT p.*, c.id AS id_cantidad, c.cantidad, cl.id AS id_cliente, cl.cliente FROM prestamos p INNER JOIN cantidades c ON p.id_cantidad = c.id INNER JOIN clientes cl ON p.id_cliente = cl.id WHERE p.id_ruta = $id_ruta";
       //Accedemos o se llama a la función o método select del Query
        $data = $this->selectAll($sql);
        return $data;
    }

    //Se crea una función de registrar usuarios donde indicamos 4 parámetros que vienen del controlador usuarios.
    public function registrarPrestamos(int $porcentaje, int $plazo, int $cantidad_dia, int $total_pago, string $fecha_inicio, string $fecha_final, string $hora_prestamo, int $id_grupo, int $id_cantidad, int $id_cliente, int $id_ruta){
        $this->porcentaje = $porcentaje;
        $this->plazo = $plazo;
        $this->cantidad_dia = $cantidad_dia;
        $this->total_pago = $total_pago;
        $this->fecha_inicio = $fecha_inicio;
        $this->fecha_final =$fecha_final;
        $this->hora_prestamo =$hora_prestamo;
        $this->id_grupo =$id_grupo;
        $this->id_cantidad =$id_cantidad;
        $this->id_cliente = $id_cliente;
        $this->id_ruta = $id_ruta;
        //Variable para verificar si hay usuarios ya existentes.    Donde la tabla trabajadores es igual al string del campo usuario
        $verificar = "SELECT * FROM prestamos WHERE id_cliente = $id_cliente AND estado = 1";
        //Se ejecuta trayendo el método select que ya se tiene creado como parámetro se le pasa el parámetro $verificar y todo eso se almacena en una variable.
        $existe = $this->select($verificar);
        //Se erifica con un if. Si existe se hace la consulta
        if (empty($existe)) {
            //Se crea una variable sql donde se hace la consulta
            $sql = "INSERT INTO prestamos(porcentaje, plazo, cantidad_dias, total_pago, fecha_inicial, fecha_final, hora_prestamo, id_grupo, id_cantidad, id_cliente, id_ruta) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            //Se crea una variable que contiene el array donde indicamos las variables creadas con los this y esa variable se enviará a la carpeta config/App/Query.php
            $datos = array($this->porcentaje, $this->plazo, $this->cantidad_dia, $this->total_pago, $this->fecha_inicio, $this->fecha_final, $this->hora_prestamo, $this->id_grupo, $this->id_cantidad, $this->id_cliente, $this->id_ruta);

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
    public function registrarSaldo(int $saldo, int $saldo_vencido, string $fecha_saldo, int $id_cliente){
        $this->saldo = $saldo;
        $this->saldo_vencido = $saldo_vencido;
        $this->fecha_saldo = $fecha_saldo;
        $this->id_cliente = $id_cliente;
        $verificar = "SELECT * FROM saldos WHERE id_cliente = $id_cliente";
        //Se ejecuta trayendo el método select que ya se tiene creado como parámetro se le pasa el parámetro $verificar y todo eso se almacena en una variable.
        $existe = $this->select($verificar);
        //Se erifica con un if. Si existe se hace la consulta
        if (empty($existe)) {
            //Se crea una variable sql donde se hace la consulta
            $sql = "INSERT INTO saldos(saldo, saldo_vencido, fecha_saldo, id_cliente) VALUES(?,?,?,?)";

            //Se crea una variable que contiene el array donde indicamos las variables creadas con los this y esa variable se enviará a la carpeta config/App/Query.php
            $datos = array($this->saldo, $this->saldo_vencido, $this->fecha_saldo, $this->id_cliente);

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
    
    //Se crea una función de modificar usuarios (btn modificar), donde indicamos 4 parámetros que vienen del controlador usuarios
    public function modificarPrestamos(int $porcentaje, int $plazo, int $cantidad_dia, int $total_pago, string $fecha_inicio, string $fecha_final, string $hora_prestamo, int $id_grupo, int $id_cantidad, int $id_cliente, int $id_ruta, int $id){
        $this->porcentaje = $porcentaje;
        $this->plazo = $plazo;
        $this->cantidad_dia = $cantidad_dia;
        $this->total_pago = $total_pago;
        $this->fecha_inicio = $fecha_inicio;
        $this->fecha_final =$fecha_final;
        $this->hora_prestamo =$hora_prestamo;
        $this->id_grupo =$id_grupo;
        $this->id_cantidad =$id_cantidad;
        $this->id_cliente = $id_cliente;
        $this->id_ruta = $id_ruta;
        
        $this->id = $id;
        
         //Se crea una variable sql donde se hace la consulta de actualizar los datos. Actualiza de la tabla trabajadores los campos
        $sql = "UPDATE prestamos SET plazo = ?, cantidad_dia = ?, total_pago = ?, fecha_inicio = ?, fecha_final = ?, hora_prestamo = ?, id_grupo = ?, id_cantidad = ? WHERE  id_cliente = ? AND id = ?";

         //Se crea una variable que contiene el array donde indicamos las variables creadas con los this y esa variable se enviará a la carpeta config/App/Query.php
        $datos = array($this->plazo, $this->cantidad_dia, $this->total_pago, $this->fecha_inicio, $this->fecha_final, $this->hora_prestamo, $this->id_grupo, $this->id_cantidad , $this->id_cliente, $this->id);

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
    
    public function modificarSaldo(int $saldo, int $saldo_vencido, string $fecha_saldo, int $id_cliente, int $id){
        $this->saldo = $saldo;
        $this->saldo_vencido = $saldo_vencido;
        $this->fecha_saldo = $fecha_saldo;
        $this->id_cliente = $id_cliente;
        $this->id = $id;
        
        
         //Se crea una variable sql donde se hace la consulta de actualizar los datos. Actualiza de la tabla trabajadores los campos
        $sql = "UPDATE saldos SET saldo = ?, saldo_vencido = ?, fecha_saldo = ? WHERE  id_cliente = ? AND id = ?";

         //Se crea una variable que contiene el array donde indicamos las variables creadas con los this y esa variable se enviará a la carpeta config/App/Query.php
        $datos = array($this->saldo, $this->saldo_vencido, $this->fecha_saldo, $this->id_cliente, $this->id);

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
    public function editarPrestamo(int $id)
    {
        //Se crea una variable sql donde almacena la consulta a la bd.
        // Selecciona toda la tabla de trabajadores donde el id sea igual al parametro $id   
        $sql = "SELECT pr.*, s.*, pr.id AS id_prestamo, s.id AS id_saldo FROM prestamos pr INNER JOIN saldos s ON pr.id = s.id  WHERE pr.id = $id";

        //Se crea una variable donde almacena el llamado al método select() donde se obtiene un solo dato y se le pasa a la variable $sql
        $data = $this->select($sql);

        //Se retorna la variable
        return $data;
    }

    public function infoClientes(int $id)
    {
        //Se crea una variable sql donde almacena la consulta a la bd.
        // Selecciona toda la tabla de trabajadores donde el id sea igual al parametro $id   
        $sql = "SELECT cl.*, pr.*, g.*, s.*,
        cl.id AS id_cliente,
        pr.id AS id_prestamo,
        g.id AS id_grupo,
        s.id AS id_saldo,
        p.id AS id_pago,
        g.grupo, s.saldo,
        COALESCE(dias_atraso, 0) AS dias_atraso,
        COALESCE(cuotas_vencidas, 0) AS cuotas_vencidas,
        SUM(p.dias_atraso),
        SUM(p.cuotas_vencidas)
        FROM clientes cl 
        INNER JOIN prestamos pr ON pr.id_cliente = cl.id INNER JOIN grupos g ON pr.id_grupo = g.id
        INNER JOIN saldos s ON s.id_cliente = cl.id
        LEFT JOIN pagos p ON p.id_cliente = cl.id
        WHERE pr.id_cliente = $id";

        //Se crea una variable donde almacena el llamado al método select() donde se obtiene un solo dato y se le pasa a la variable $sql
        $data = $this->select($sql);

        //Se retorna la variable
        return $data;
    }

    public function registrarPago(int $pago, string $tipo_pago, int $cuotas_vencidas, int $dias_atraso, string $fecha_pago, string $hora_pago, int $id_grupo, int $id_cliente, int $id_prestamo, int $id_ruta)
    {
        $this->pago = $pago;
        $this->tipo_pago = $tipo_pago;
        $this->cuotas_vencidas = $cuotas_vencidas;
        $this->dias_atraso = $dias_atraso;
        $this->fecha_pago = $fecha_pago;
        $this->hora_pago= $hora_pago;
        $this->fecha_hoy = date('Y-m-d'); //Este campo se registra en la bd. Pero le puse da('Y-m-d') para hacer mis pruebas, pero no lo lleva
        $this->id_grupo = $id_grupo;
        $this->id_cliente = $id_cliente;
        $this->id_prestamo = $id_prestamo;
        $this->id_ruta = $id_ruta;
            //Se crea una variable sql donde se hace la consulta
            $sql = "INSERT INTO pagos(pago, tipo_pago, cuotas_vencidas, dias_atraso, fecha_pago, hora_pago, fecha_hoy, id_grupo, id_cliente, id_ruta) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            //Se crea una variable que contiene el array donde indicamos las variables creadas con los this y esa variable se enviará a la carpeta config/App/Query.php
            $datos = array($this->pago, $this->tipo_pago, $this->cuotas_vencidas, $this->dias_atraso, $this->fecha_pago, $this->hora_pago, $this->fecha_hoy, $this->id_grupo, $this->id_cliente, $this->id_ruta);

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

    //Se crea una función del botón eliminar usuarios y poder visualizarlo en el index, donde indicamos 1 parámetro de tipo int que vienen del controlador usuarios. NOTA: Solo cambia el estado de actio a inactivo y viceversa
    public function accionPrestamo(int $estado, int $id)
    {
        //Se almacenan los parámetros
        $this->id = $id;
        $this->estado = $estado;

        //Se crea una variable sql donde se hace la consulta de actualizar los datos. Actualiza de la tabla trabajadores el campo estado que es igual a 0 donde el id es igual a la selección que viene del controlador
        $sql = "UPDATE prestamos SET estado = ? WHERE id = ?";

        //Se crea una variable donde almacenan los arreglo que se le pasa al estado y al id
        $datos = array($this->estado, $this->id); 

        //Se crea una variable donde almacena el llamado al método select() donde se obtiene dos datos uno de tipo string ($sql) y un arreglo ($datos)
        $data = $this->save($sql, $datos);

        //Se retorna la variable
        return $data;

    }
}
