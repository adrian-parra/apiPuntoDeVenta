<?php
require_once('../conexion.php');
require_once('../cors.php');
require_once('./controller_historial_de_inventario.php');


$methodHTTP = $_SERVER['REQUEST_METHOD'];

switch ($methodHTTP) {

  case 'POST':
      if(isset($_GET["insertar"])){
        $data = json_decode(file_get_contents('php://input'), true);  

        $result = ControllerHistorialInventario::addHistorial($data);
        echo json_encode($result);
        exit();//FINALIZAMOS LA EJECUCION DE LA API

    }
    if(isset($_GET["actualizar"])){
      $data = json_decode(file_get_contents('php://input'), true);  
      
      exit();
    }
      break;
  case 'GET':
    if(empty($_GET)){
      $historial = ControllerHistorialInventario::getHistorial();
      echo json_encode($historial);
      exit();
    }else {
      $data = $_GET;
   
      exit();
    }
    break;

}      
?>