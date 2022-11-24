<?php 

require_once('../conexion.php');
require_once('../cors.php');
require_once('./controller_detalle_orden_de_compra.php');


$methodHTTP = $_SERVER['REQUEST_METHOD'];

switch ($methodHTTP) {

  case 'POST':
      if(isset($_GET["insertar"])){
        $data = json_decode(file_get_contents('php://input'), true);  

       
        exit();//FINALIZAMOS LA EJECUCION DE LA API

    }

    if(isset($_GET["insertarDetalleOrdenDeCompra"])){
        $data = json_decode(file_get_contents('php://input'), true);  

       
        exit();//FINALIZAMOS LA EJECUCION DE LA API

    }
    if(isset($_GET["actualizar"])){
      $data = json_decode(file_get_contents('php://input'), true);  

      $result = ControllerDetalleOrdenDeCompra::updateDetalleOrdenDeCompra($data);

      echo json_encode(($result));
      exit();
    }
      break;
  case 'GET':
    if(empty($_GET)){
     
      exit();
    }else {
      $data = $_GET;
      $detallesOrdenArticulo = ControllerDetalleOrdenDeCompra::getDetallesOrdeneDeCompra($data);

      echo json_encode($detallesOrdenArticulo);
      exit();
    }
    break;

}      

?>