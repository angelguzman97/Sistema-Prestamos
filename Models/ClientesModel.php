<?php
class ClientesModel extends Query
{
    //Se crean los parámetros que irán dentro de la función registrarUsuarios()
    private $cliente, $apellidos, $telefono, $edad, $direccion, $trabajo, $img, $id, $estado, $fecharegistro, $hora_cliente, $id_ruta;
    //Se crean los parámetros que irán dentro de la función editarUser()

    public function __construct()
    {
        parent::__construct();
    }
    

    //Función para mostrar la lista de los usuarios
    public function getClientesTemp(int $id_ruta, string $fecharegistro)
    {  
        //Al c.id se le coloca un alias ara que no muetre el id de las cajas, sino del id del trabajador 
        $sql = "SELECT * FROM clientes WHERE id_ruta = $id_ruta AND fecha_registro = '$fecharegistro'";
        //Accedemos o se llama a la función o método select del Query
        $data = $this->selectAll($sql);
        return $data;
    }
    //Función para mostrar la lista de los usuarios
    public function getClientes(int $id_ruta)
    {  
        //Al c.id se le coloca un alias ara que no muetre el id de las cajas, sino del id del trabajador 
        $sql = "SELECT * FROM clientes WHERE id_ruta = $id_ruta";
        //Accedemos o se llama a la función o método select del Query
        $data = $this->selectAll($sql);
        return $data;
    }

    //Se crea una función de registrar usuarios donde indicamos 4 parámetros que vienen del controlador usuarios.
    public function registrarClientes(string $cliente, string $apellidos, int $edad, string $telefono, string $direccion, string $trabajo, string $img, string $fecharegistro, string $hora_cliente, int $id_ruta){
        $this->cliente = $cliente;
        $this->apellidos = $apellidos;
        $this->edad = $edad;
        $this->telefono = $telefono;
        $this->direccion = $direccion;
        $this->trabajo = $trabajo;
        $this->img = $img;
        $this->fecharegistro = $fecharegistro;
        $this->hora_cliente = $hora_cliente;
        $this->id_ruta = $id_ruta;
        //Variable para verificar si hay usuarios ya existentes.    Donde la tabla trabajadores es igual al string del campo usuario
        $verificar = "SELECT * FROM clientes WHERE cliente = '$cliente' AND apellidos= '$apellidos'";
        //Se ejecuta trayendo el método select que ya se tiene creado como parámetro se le pasa el parámetro $verificar y todo eso se almacena en una variable.
        $existe = $this->select($verificar);
        //Se erifica con un if. Si existe se hace la consulta
        if (empty($existe)) {
            //Se crea una variable sql donde se hace la consulta
            $sql = "INSERT INTO clientes(cliente, apellidos, edad, telefono, direccion, trabajo, foto, fecha_registro, hora_cliente, id_ruta) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            //Se crea una variable que contiene el array donde indicamos las variables creadas con los this y esa variable se enviará a la carpeta config/App/Query.php
            $datos = array($this->cliente, $this->apellidos, $this->edad, $this->telefono, $this->direccion, $this->trabajo, $this->img, $this->fecharegistro, $this->hora_cliente, $this->id_ruta);

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
     public function modificarClientes(string $cliente, string $apellidos, int $edad, string $telefono, string $direccion, string $trabajo, string $img, string $fecharegistro, string $hora_cliente, int $id_ruta, int $id)
     {
         $this->cliente = $cliente;
         $this->apellidos = $apellidos;
         $this->edad = $edad;
         $this->telefono = $telefono;
         $this->direccion = $direccion;
         $this->trabajo = $trabajo;
         $this->img = $img;
         $this->fecharegistro = $fecharegistro;
         $this->hora_cliente = $hora_cliente;
         $this->id_ruta = $id_ruta;
         $this->id = $id;
         
         //Se crea una variable sql donde se hace la consulta de actualizar los datos. Actualiza de la tabla trabajadores los campos
         $sql = "UPDATE clientes SET cliente = ?, apellidos = ?, edad = ?, telefono = ?, direccion = ?, trabajo = ?, foto = ?, fecha_registro = ?, hora_cliente = ? WHERE id_ruta = ? AND id= ?";
 
         //Se crea una variable que contiene el array donde indicamos las variables creadas con los this y esa variable se enviará a la carpeta config/App/Query.php
         $datos = array($this->cliente, $this->apellidos, $this->edad, $this->telefono, $this->direccion, $this->trabajo, $this->img, $this->fecharegistro, $this->hora_cliente, $this->id_ruta, $this->id);

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
    public function editarcliente(int $id)
    {
        //Se crea una variable sql donde almacena la consulta a la bd.
        // Selecciona toda la tabla de trabajadores donde el id sea igual al parametro $id   
        $sql = "SELECT * FROM clientes WHERE id = $id";

        //Se crea una variable donde almacena el llamado al método select() donde se obtiene un solo dato y se le pasa a la variable $sql
        $data = $this->select($sql);

        //Se retorna la variable
        return $data;
    }

    //Se crea una función del botón eliminar usuarios y poder visualizarlo en el index, donde indicamos 1 parámetro de tipo int que vienen del controlador usuarios. NOTA: Solo cambia el estado de actio a inactivo y viceversa
    public function accionCliente(int $estado, int $id)
    {
          //Se almacenan los parámetros
          $this->id = $id;
          $this->estado = $estado;
  
          //Se crea una variable sql donde se hace la consulta de actualizar los datos. Actualiza de la tabla trabajadores el campo estado que es igual a 0 donde el id es igual a la selección que viene del controlador
          $sql = "UPDATE clientes SET estado = ? WHERE id = ?";
  
          //Se crea una variable donde almacenan los arreglo que se le pasa al estado y al id
          $datos = array($this->estado, $this->id); 
  
          //Se crea una variable donde almacena el llamado al método select() donde se obtiene dos datos uno de tipo string ($sql) y un arreglo ($datos)
          $data = $this->save($sql, $datos);
  
          //Se retorna la variable
          return $data;
  
    }
}
?>