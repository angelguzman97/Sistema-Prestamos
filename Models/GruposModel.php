<?php
class GruposModel extends Query
{
    //Se crean los parámetros que irán dentro de la función registrarUsuarios()
    private $grupo, $id, $estado;
    //Se crean los parámetros que irán dentro de la función editarUser()

    public function __construct()
    {
        parent::__construct();
    }
    
    //Función para mostrar la lista de los usuarios o trabajadores
    public function getGrupo()
    {   //Se trae todos los datos de clientes de la bd
        $sql = "SELECT * FROM grupos";
        //Accedemos o se llama a la función o método select del Query
        $data = $this->selectAll($sql);
        return $data;
    }

    //Se crea una función de registrar usuarios donde indicamos 4 parámetros que vienen del controlador usuarios.
    public function registrarGrupo(string $grupo)
    {
        $this->grupo = $grupo;
        //Variable para verificar si hay usuarios ya existentes.    Donde la tabla trabajadores es igual al int del campo curp
        $verificar = "SELECT * FROM grupos WHERE grupo = '$this->grupo'";
        //Se ejecuta trayendo el método select que ya se tiene creado como parámetro se le pasa el parámetro $verificar y todo eso se almacena en una variable.
        $existe = $this->select($verificar);
        //Se erifica con un if. Si existe se hace la consulta
        if (empty($existe)) {
            //Se crea una variable sql donde se hace la consulta
            $sql = "INSERT INTO grupos(grupo) VALUES(?)";

            //Se crea una variable que contiene el array donde indicamos las variables creadas con los this y esa variable se enviará a la carpeta config/App/Query.php
            $datos = array($this->grupo);

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

     //Se crea una función de modificar cliente (btn modificar), donde indicamos 5 parámetros que vienen del controlador usuarios
     public function modificarGrupo(string $grupo, int $id)
     {
         $this->grupo = $grupo;
         $this->id = $id;
         
         //Se crea una variable sql donde se hace la consulta de actualizar los datos. Actualiza de la tabla clientes los campos
         $sql = "UPDATE grupos SET grupo = ? WHERE id = ?";
 
         //Se crea una variable que contiene el array donde indicamos las variables creadas con los this y esa variable se enviará a la carpeta config/App/Query.php
         $datos = array($this->grupo, $this->id);

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

    //Se crea una función del botón editar cliente y poder visualizarlo en el index, donde indicamos 1 parámetro de tipo int que vienen del controlador usuarios
    public function editarGrupo(int $id)
    {
        //Se crea una variable sql donde almacena la consulta a la bd.
        // Selecciona toda la tabla de trabajadores donde el id sea igual al parametro $id   
        $sql = "SELECT * FROM grupos WHERE id = $id";

        //Se crea una variable donde almacena el llamado al método select() donde se obtiene un solo dato y se le pasa a la variable $sql
        $data = $this->select($sql);

        //Se retorna la variable
        return $data;
    }

    //Se crea una función del botón eliminar usuarios y poder visualizarlo en el index, donde indicamos 1 parámetro de tipo int que vienen del controlador usuarios. NOTA: Solo cambia el estado de actio a inactivo y viceversa
    public function accionGrupo(int $estado, int $id)
    {
        //Se almacenan los parámetros
        $this->id = $id;
        $this->estado = $estado;

        //Se crea una variable sql donde se hace la consulta de actualizar los datos. Actualiza de la tabla trabajadores el campo estado que es igual a 0 donde el id es igual a la selección que viene del controlador
        $sql = "UPDATE grupos SET estado = ? WHERE id = ?";

        //Se crea una variable donde almacenan los arreglo que se le pasa al estado y al id
        $datos = array($this->estado, $this->id); 

        //Se crea una variable donde almacena el llamado al método select() donde se obtiene dos datos uno de tipo int ($sql) y un arreglo ($datos)
        $data = $this->save($sql, $datos);

        //Se retorna la variable
        return $data;

    }
}
