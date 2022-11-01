<?php 

require_once('../conexion.php');
require_once('../cors.php');

require_once('controller_articulo.php');

$methodHTTP = $_SERVER['REQUEST_METHOD'];
switch ($methodHTTP) {

    case 'GET':
        if(isset($_GET["insertar"])){
          $data = json_decode(file_get_contents('php://input'), true);  
  
          
  
          $ctl = new ControllerArticulo();
          $result = $ctl->addArticulo($data);
          echo json_encode($result);
           exit();//FINALIZAMOS LA EJECUCION DE LA API
  
      }
        break;
  }
  
?>