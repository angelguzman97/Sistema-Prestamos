<?php
class Conexion{
    private $conect;

    public function __construct()
    {
        $pdo = 'mysql:host='.host.';dbname='.db.';charset.';
        try {
            //Método
            $this->conect = new PDO($pdo, user, pass);
            //Atributo
            $this->conect-> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Error en la conexión".$e->getMessage();
        }
    }
    public function conect()
    {
        return $this->conect;
    }
}
?>