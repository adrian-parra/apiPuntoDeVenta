<?php 

require_once('../conexion.php');
require_once('../cors.php');
require_once('controller_proveedor.php');

$methodHTTP = $_SERVER['REQUEST_METHOD'];

switch ($methodHTTP) {

  case 'POST':
      if(isset($_GET["insertar"])){
        $data = json_decode(file_get_contents('php://input'), true);  

        

        $ctl = new ControllerProveedor();
        $result = $ctl->addProveedor($data);
        echo json_encode($result);
         exit();//FINALIZAMOS LA EJECUCION DE LA API

    }
      break;
  case 'GET':
    if(empty($_GET)){
      $proveedores = ControllerProveedor::getProveedores();
      echo json_encode($proveedores);
      exit();
    }else {
      $data = $_GET;
      $proveedor = ControllerProveedor::getProveedor($data);
      echo json_encode($proveedor);
      exit();
    }
    break;
}
?>