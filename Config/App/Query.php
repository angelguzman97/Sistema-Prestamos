<?php
//Heredación
class Query extends Conexion{
    //Se crean los parámetros 
    private $pdo, $con, $sql, $datos;
    public function __construct()
    {
    $this->pdo = new Conexion();   
     //pasamos a la variable "con" el "pdo" y accedemos a su método "conect()"
    $this->con = $this->pdo->conect();
    }

    //Función para hacer la consulta Select de sql
    public function select(string $sql)
    {
        $this->sql = $sql;
        //pasamos a la variable "result" accedemos a la "conexion" y se hace una consulta con "prepare()"
        $resul = $this->con-> prepare($this->sql);
        //Se ejecuta la variable o conexion a la bd
        $resul -> execute();
        //indicamos que solo se traerá un solo registro
        $data = $resul -> fetch(PDO::FETCH_ASSOC); 
        return $data;
    }

    //Función para hacer la consulta Select de sql y mostrar todo
    public function selectAll(string $sql)
    {
        $this->sql = $sql;
        //pasamos a la variable "result" accedemos a la "conexion" y se hace una consulta con "prepare()"
        $resul = $this->con-> prepare($this->sql);
        //Se ejecuta la variable o conexion a la bd
        $resul -> execute();
        //indicamos que solo se traerá todos los registros
        $data = $resul -> fetchAll(PDO::FETCH_ASSOC); 
        return $data;
    }

    //Se crea una función o método para guardar los datos del registro de usuarios. Se le indican los parámetros. Y este se le hace el llamado en dentro del modeloUsuarios
    public function save(string $sql, Array $datos)
    {
        $this->sql = $sql;
        $this-> datos = $datos;
        //Se crea una varible donde accedemos a la conexión para insertar los datos
        $insert = $this->con->prepare($this->sql);
        //Se crea una variable donde se ejecuta la variable insert y dentro de execute se envía al arreglo
        $data = $insert -> execute($this->datos);
        //Se verifica si ejecutó bien el Query
        if ($data) {
            //Si se ejecuta que devuelva 1
            $res = 1;
        }else{
            $res = 0;
        }
        return $res;
    }

}
?>