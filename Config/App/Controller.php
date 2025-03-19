<?php
//Se crea la clase controlador
class Controller{
    //Se crea un constructor
public function __construct()
{
    //Se crea un nuevo objeto
    $this-> views = new Views();
    //Se llama a la función de cargar modelo
    $this->cargarModel();
}

//Se crea el método para cargar el modelo
public function cargarModel()
{
    //Se crea la variable que devolverá una clase
    $model = get_class($this).'Model';
    //Variable que almacena la ruta de las carpetas
    $ruta = 'Models/'.$model.'.php';
    if (file_exists($ruta)) {
        require_once($ruta);
        $this-> model = new $model();
    }

}
}
?>