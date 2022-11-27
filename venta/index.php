<?php 

require_once('../conexion.php');
require_once('../cors.php');
require_once('./controller_venta.php');


$methodHTTP = $_SERVER['REQUEST_METHOD'];

switch ($methodHTTP) {

  case 'POST':
      if(isset($_GET["insertar"])){
        $data = json_decode(file_get_contents('php://input'), true);  

        $result = ControllerVenta::addVenta($data);

        echo json_encode($result);
        exit();//FINALIZAMOS LA EJECUCION DE LA API

    }
    if(isset($_GET["actualizarStockArticulo"])){
      $data = json_decode(file_get_contents('php://input'), true);  

    $result = ControllerVenta::updateStockArticuloInventario($data);

    echo json_encode($result);
    
      exit();
    }
      break;
  case 'GET':
    if(empty($_GET)){
      
      exit();
    }else {
      $data = $_GET;
      $datos = ControllerVenta::getReciboVenta($data);

      echo json_encode($datos);
      exit();
    }
    break;

}      

?>