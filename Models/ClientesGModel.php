<?php
class ClientesGModel extends Query
{
    //Se crean los parámetros que irán dentro de la función registrarUsuarios()
    private $cliente, $apellidos, $telefono, $edad, $direccion, $trabajo, $img, $id, $estado, $fecharegistro, $id_ruta;
    //Se crean los parámetros que irán dentro de la función editarUser()

    public function __construct()
    {
        parent::__construct();
    }

    public function getClientesG()
    {
        //Al c.id se le coloca un alias ara que no muetre el id de las cajas, sino del id del trabajador 
        $sql = "SELECT cl.*, s.id AS id_saldo, s.saldo, pr.id AS id_prestamo, pr.total_pago, cl.id AS id_cliente, r.ruta
        FROM clientes cl INNER JOIN rutas r ON cl.id_ruta = r.id LEFT JOIN saldos s ON s.id_cliente = cl.id LEFT JOIN prestamos pr ON pr.id_cliente = cl.id";
        //Accedemos o se llama a la función o método select del Query
        $data = $this->selectAll($sql);
        return $data;
    }

    //Se crea una función del botón editar usuarios y poder visualizarlo en el index, donde indicamos 1 parámetro de tipo int que vienen del controlador usuarios
    public function infoClientes(int $id)
    {
        //Se crea una variable sql donde almacena la consulta a la bd.
        // Selecciona toda la tabla de trabajadores donde el id sea igual al parametro $id   
        // $sql = "SELECT cl.*, pr.*, g.*,s.*,
        // cl.id AS id_cliente,
        // pr.id AS id_prestamo,
        // g.id AS id_grupo,
        // s.id AS id_saldo,
        // p.id AS id_pago,
        // s.saldo, s.saldo_vencido, g.grupo,
        // COALESCE(dias_atraso, 0) AS dias_atraso,
        // COALESCE(cuotas_vencidas, 0) AS cuotas_vencidas,
        // SUM(p.dias_atraso),
        // SUM(p.cuotas_vencidas)
        // FROM clientes cl 
        // INNER JOIN prestamos pr ON pr.id_cliente = cl.id INNER JOIN grupos g ON pr.id_grupo = g.id
        // INNER JOIN saldos s ON s.id_cliente = cl.id
        // INNER JOIN pagos p ON p.id_cliente = cl.id
        // WHERE cl.id = $id";
        $verificar = "SELECT * FROM saldos WHERE id_cliente = $id";
        $ver = $this->select($verificar);

        if ($ver != null) {
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
        INNER JOIN saldos s ON s.id_cliente = cl.id
        LEFT JOIN pagos p ON p.id_cliente = cl.id
        WHERE cl.id = $id";

            //Se crea una variable donde almacena el llamado al método select() donde se obtiene un solo dato y se le pasa a la variable $sql
            $data = $this->select($sql);

            //Se retorna la variable
            return $data;
        } else {
            $sql = "SELECT * FROM clientes WHERE id = $id";
            //Se crea una variable donde almacena el llamado al método select() donde se obtiene un solo dato y se le pasa a la variable $sql
            $data = $this->select($sql);

            //Se retorna la variable
            return $data;
        }
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

    public function borrarCreditoCliente(int $id)
    {
        $this->id = $id;
        $sql = "DELETE s, pr
FROM saldos s
INNER JOIN prestamos pr ON s.id_cliente = pr.id_cliente
WHERE pr.id_cliente = ?";
        $datos = array($this->id);
        $data = $this->save($sql, $datos);
        return $data;
    }
    
    public function borrarPagoIdCliente(int $id)
    {
        $sql = "DELETE FROM pagos WHERE id = ?";
        $data = $this->save($sql, [$id]);
        return $data;
    }
}
