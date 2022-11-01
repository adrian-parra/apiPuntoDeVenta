<?php 
require_once('../conexion.php');
require_once('../cors.php');
require_once('../empresa/controller_empresa.php');
require_once('../empleado/controller_empleado.php');
require_once('controller_usuario.php');



$methodHTTP = $_SERVER['REQUEST_METHOD'];

switch ($methodHTTP) {

  case 'POST':
      if(isset($_GET["insertar"])){
        $data = json_decode(file_get_contents('php://input'), true);  
        $ctl = new ControllerUsuario();
        $result = $ctl->addUsuario($data);
        echo json_encode($result);
        exit();//FINALIZAMOS LA EJECUCION DE LA API
      }
      if(isset($_GET["verificar_sesion"])){
        $data = json_decode(file_get_contents('php://input'), true);  
        $result = ControllerUsuario::verificarSesion($data);
        echo json_encode($result);
        exit();
      }
    
      break;
  case 'GET':
   
    

    break;

}      

?>