<?php 

require_once('../conexion.php');
require_once('../cors.php');
require_once('./controller_orden_de_compra.php');


$methodHTTP = $_SERVER['REQUEST_METHOD'];

switch ($methodHTTP) {

  case 'POST':
      if(isset($_GET["insertar"])){
        $data = json_decode(file_get_contents('php://input'), true);  

        $result = ControllerOrdenDeCompra::addOrdenDeCompra($data);

        echo json_encode($result);
        exit();//FINALIZAMOS LA EJECUCION DE LA API

    }

    if(isset($_GET["insertarDetalleOrdenDeCompra"])){
        $data = json_decode(file_get_contents('php://input'), true);  

        $result = ControllerOrdenDeCompra::addDetalleOrdenDeCompra($data);

        echo json_encode($result);
        exit();//FINALIZAMOS LA EJECUCION DE LA API

    }
    if(isset($_GET["actualizar"])){
      $data = json_decode(file_get_contents('php://input'), true);  

      $result = ControllerOrdenDeCompra::updateOrdenCompra($data);

      echo json_encode($result);
     
      exit();
    }
      break;
  case 'GET':
    if(empty($_GET)){
      $ordenesDeCompra = ControllerOrdenDeCompra::getOrdenDeCompra();

      echo json_encode($ordenesDeCompra);
      exit();
    }else {
      $data = $_GET;
      $ordenCompra = ControllerOrdenDeCompra::getOrdenCompra($data);

      echo json_encode($ordenCompra);
      exit();
    }
    break;

}      

?>