<?php 
require_once('../conexion.php');
require_once('../cors.php');
require_once('controller_cliente.php');

$methodHTTP = $_SERVER['REQUEST_METHOD'];
switch ($methodHTTP) {

    case 'POST':
        if(isset($_GET["insertar"])){
          $data = json_decode(file_get_contents('php://input'), true);  
  
          
  
          $ctl = new ControllerCliente();
          $result = $ctl->addCliente($data);
          echo json_encode($result);
           exit();//FINALIZAMOS LA EJECUCION DE LA API
  
      }
      if(isset($_GET["actualizar"])){
        $data = json_decode(file_get_contents('php://input'), true); 

        $result = ControllerCliente::updateCliente($data);
        echo json_encode($result);
        exit(); 

      }
        break;
    case 'GET':
      if(empty($_GET)){
        $clientes = ControllerCliente::getClientes();
        echo json_encode($clientes);
        exit();
      }else {
        $data = $_GET;
        $cliente = ControllerCliente::getCliente($data);
        echo json_encode($cliente);
        exit();
      }
      break;
  }
  
?>