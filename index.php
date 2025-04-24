<?php
//Requerimos el archivo que contiene la url raíz
require_once "Config/Config.php";

//Toma la url
$ruta = !empty($_GET['url']) ? $_GET['url'] : "Home/index";
$array = explode("/", $ruta);
$controller = $array[0];
$metodo = "index";
$parametro = "";

//Se verfica si existe algún método
if(!empty($array[1])){
   if (!empty($array[1] != "")) {
      $metodo =$array[1];
   }
}

//Se verifica si hay algún párametro
if(!empty($array[2])){
   if (!empty($array[2] != "")) {
      for ($i=2; $i < count($array); $i++) { 
         $parametro .= $array[$i]. ",";
      }
      $parametro = trim($parametro, ",");      
   }
}
//Requerimos el archivo que está en esa ruta
require_once "Config/App/autoload.php";

//Se asigna una variable para guardar los controladores o archivos
$dirControllers = "Controllers/". $controller.".php";
//Se verifica si existe algún archivo
if (file_exists($dirControllers)) {
   //Si existe se requiere
   require_once $dirControllers;
   //Se crea una instancia u objeto
   $controller = new $controller();
   if (method_exists($controller, $metodo)) {
      //Se llama al controlador y se le asigna el método junto con su párametro
      $controller->$metodo($parametro);
   }else{
      header("location: ".base_url);
   }
}else{
   header("location: ".base_url);
}
?>