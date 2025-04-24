<?php
class PerfilModel extends Query
{
    private $ruta, $nombre, $telefono, $id_ruta;
//Este constructor se hace igual en el controlador home
public function __construct()
{
    //La palabra reservada parent nos sirve para llamarla desde una clase extendida.
    //Cargar el constructor a las vistas
    parent::__construct();
}
public function perfilRuta(int $id_ruta)
{
   $sql="SELECT*FROM rutas WHERE id = $id_ruta";
   $data = $this->select($sql);
   return $data;
}
public function editarPerfilRuta(string $ruta, string $nombre, string $telefono, int $id_ruta)
{
        $this->ruta = $ruta;
        $this->nombre = $nombre;
        $this->telefono = $telefono;
         $this->id_ruta = $id_ruta;
         
         //Se crea una variable sql donde se hace la consulta de actualizar los datos. Actualiza de la tabla clientes los campos
         $sql = "UPDATE rutas SET ruta = ?, nombre = ?, telefono = ? WHERE id = ?";
 
         //Se crea una variable que contiene el array donde indicamos las variables creadas con los this y esa variable se enviará a la carpeta config/App/Query.php
         $datos = array($this->ruta, $this->nombre, $this->telefono, $this->id_ruta);

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
}
?>