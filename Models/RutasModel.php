<?php
class RutasModel extends Query
{
    //Se crean los parámetros que irán dentro de la función registrarRutas()
    private $ruta, $nombre, $clave, $telefono, $id, $estado, $caja_inicial, $caja_anterior, $img;
    //Se crean los parámetros que irán dentro de la función editarUser()

    public function __construct()
    {
        parent::__construct();
    }
    //Función para validar el ruta admin desde la bd
    public function getRuta(string $ruta, string $clave)
    {
        $sql = "SELECT * FROM rutas WHERE ruta = '$ruta' AND clave = '$clave'";
        //Accedemos a la función select del Query
        $data = $this->select($sql);
        return $data;
    }
    
    /* $sql ="SELECT * FROM clientes WHERE id_ruta IN (SELECT id FROM rutas WHERE ruta='$ruta')";
        $data = $this->selectAll($sql);
        return $data;*/

    //Función para mostrar la lista de los rutas o trabajadores
    public function getRutas()
    {      //Al c.id se le coloca un alias ara que no muetre el id de las cajas, sino del id del trabajador 
        $sql = "SELECT * FROM rutas";
        //Accedemos o se llama a la función o método select del Query
        $listarR = $this->selectAll($sql);
        return $listarR;
    }
    
    
    public function getTablasRutas(int $id_ruta)
    {      //Al c.id se le coloca un alias ara que no muetre el id de las cajas, sino del id del trabajador 
        $sql = "SELECT *FROM rutas WHERE id != $id_ruta";
        //Accedemos o se llama a la función o método select del Query
        $listarR = $this->selectAll($sql);
        return $listarR;
    }


    //Se crea una función de registrar rutas donde indicamos 4 parámetros que vienen del controlador rutas.
    public function registrarRutas(string $ruta, string $clave, string $nombre, string $telefono, int $caja_inicial, string $img)
    {
        $this->ruta = $ruta;
        $this->clave = $clave;
        $this->nombre = $nombre;
        $this->telefono = $telefono;
        $this->caja_inicial = $caja_inicial;
        $this->img = $img;
        // $this->fecha_ruta = $fecha_ruta;
        //Variable para verificar si hay rutas ya existentes.    Donde la tabla trabajadores es igual al string del campo ruta
        $verificar = "SELECT * FROM rutas WHERE ruta = '$this->ruta'";
        //Se ejecuta trayendo el método select que ya se tiene creado como parámetro se le pasa el parámetro $verificar y todo eso se almacena en una variable.
        $existe = $this->select($verificar);
        //Se erifica con un if. Si existe se hace la consulta
        if (empty($existe)) {
            //Se crea una variable sql donde se hace la consulta
            $sql = "INSERT INTO rutas(ruta, clave, nombre, telefono, caja_inicial, foto) VALUES(?, ?, ?, ?, ?, ?)";

            //Se crea una variable que contiene el array donde indicamos las variables creadas con los this y esa variable se enviará a la carpeta config/App/Query.php
            $datos = array($this->ruta, $this->clave, $this->nombre, $this->telefono, $this->caja_inicial, $this->img);

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

    public function modificarRutasClave(string $ruta, string $clave, string $nombre, string $telefono, int $caja_inicial, string $img, int $id)
     {
         $this->ruta = $ruta;
         $this->clave = $clave;
         $this->nombre = $nombre;
         $this->telefono = $telefono;
         $this->caja_inicial = $caja_inicial;
         $this->img = $img;
        //  $this->fecha_ruta = $fecha_ruta;
         $this->id = $id;
         
         //Se crea una variable sql donde se hace la consulta de actualizar los datos. Actualiza de la tabla trabajadores los campos
         $sql = "UPDATE rutas SET ruta = ?, clave = ?, nombre = ?, telefono = ?, caja_inicial = ?, foto = ? WHERE id = ?";
 
         //Se crea una variable que contiene el array donde indicamos las variables creadas con los this y esa variable se enviará a la carpeta config/App/Query.php
         $datos = array($this->ruta, $this->clave, $this->nombre, $this->telefono, $this->caja_inicial, $this->img, $this->id);

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

     //Se crea una función de modificar rutas (btn modificar), donde indicamos 4 parámetros que vienen del controlador rutas
     public function modificarRutas(string $ruta, string $nombre, string $telefono, int $caja_inicial, string $img, int $id)
     {
         $this->ruta = $ruta;
         $this->nombre = $nombre;
         $this->telefono = $telefono;
         $this->caja_inicial = $caja_inicial;
          $this->img = $img;
        //  $this->fecha_ruta = $fecha_ruta;
         $this->id = $id;
         
         //Se crea una variable sql donde se hace la consulta de actualizar los datos. Actualiza de la tabla trabajadores los campos
         $sql = "UPDATE rutas SET ruta = ?, nombre = ?, telefono = ?, caja_inicial = ?, foto = ? WHERE id = ?";
 
         //Se crea una variable que contiene el array donde indicamos las variables creadas con los this y esa variable se enviará a la carpeta config/App/Query.php
         $datos = array($this->ruta, $this->nombre, $this->telefono, $this->caja_inicial, $this->img, $this->id);

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

    //Se crea una función del botón editar rutas y poder visualizarlo en el index, donde indicamos 1 parámetro de tipo int que vienen del controlador rutas
    
    public function editarRuta(int $id)
    {
        //Se crea una variable sql donde almacena la consulta a la bd.
        // Selecciona toda la tabla de trabajadores donde el id sea igual al parametro $id   
        $sql = "SELECT * FROM rutas WHERE id = $id";

        //Se crea una variable donde almacena el llamado al método select() donde se obtiene un solo dato y se le pasa a la variable $sql
        $data = $this->select($sql);

        //Se retorna la variable
        return $data;
    }

    //Se crea una función del botón eliminar rutas y poder visualizarlo en el index, donde indicamos 1 parámetro de tipo int que vienen del controlador rutas. NOTA: Solo cambia el estado de actio a inactivo y viceversa
    public function accionUser(int $estado, int $id)
    {
        //Se almacenan los parámetros
        $this->id = $id;
        $this->estado = $estado;

        //Se crea una variable sql donde se hace la consulta de actualizar los datos. Actualiza de la tabla trabajadores el campo estado que es igual a 0 donde el id es igual a la selección que viene del controlador
        $sql = "UPDATE rutas SET estado = ? WHERE id = ?";

        //Se crea una variable donde almacenan los arreglo que se le pasa al estado y al id
        $datos = array($this->estado, $this->id); 

        //Se crea una variable donde almacena el llamado al método select() donde se obtiene dos datos uno de tipo string ($sql) y un arreglo ($datos)
        $data = $this->save($sql, $datos);

        //Se retorna la variable
        return $data;

    }

    //Se crea una función del botón eliminar rutas y poder visualizarlo en el index, donde indicamos 1 parámetro de tipo int que vienen del controlador rutas. NOTA: Solo cambia el estado de actio a inactivo y viceversa
    public function retiroCaja(int $caja_anterior, int $id_ruta)
    {
        //Se almacenan los parámetros
        $this->id = $id_ruta;
        $this->caja_anterior = $caja_anterior;

        //Se crea una variable sql donde se hace la consulta de actualizar los datos. Actualiza de la tabla trabajadores el campo estado que es igual a 0 donde el id es igual a la selección que viene del controlador
        $sql = "UPDATE rutas SET caja_anterior = ? WHERE id = ?";

        //Se crea una variable donde almacenan los arreglo que se le pasa al estado y al id
        $datos = array($this->caja_anterior, $this->id); 

        //Se crea una variable donde almacena el llamado al método select() donde se obtiene dos datos uno de tipo string ($sql) y un arreglo ($datos)
        $data = $this->save($sql, $datos);

        //Se retorna la variable
        return $data;

    }

    public function clientesRuta(int $id_ruta)
    {
        //Se crea una variable sql donde almacena la consulta a la bd.
        // Selecciona toda la tabla de trabajadores donde el id sea igual al parametro $id   
        $sql = "SELECT * FROM clientes WHERE id_ruta = $id_ruta ORDER BY id DESC";

        //Se crea una variable donde almacena el llamado al método select() donde se obtiene un solo dato y se le pasa a la variable $sql
        $data = $this->selectAll($sql);

        //Se retorna la variable
        return $data;
    }

    public function reportesRuta(int $id_ruta)
     {
        $sql="SELECT * FROM reportes WHERE id_ruta = $id_ruta ORDER BY id DESC";
        $data = $this->selectAll($sql);
        return $data;
     }
}
?>