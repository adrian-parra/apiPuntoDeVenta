<?php 
    require_once('../conexion.php');
    require_once('../cors.php');
    require_once('../usuario/controller_usuario.php');
    require_once('../empresa/controller_empresa.php');
    require_once('controller_empleado.php');

    $methodHTTP = $_SERVER['REQUEST_METHOD'];

switch ($methodHTTP) {

  case 'POST':
      if(isset($_GET["insertar"])){
        $data = json_decode(file_get_contents('php://input'), true);  

        

        $ctl = new ControllerEmpleado();
        $result = $ctl->addEmpleado($data);
        echo json_encode($result);
         exit();//FINALIZAMOS LA EJECUCION DE LA API

    }

    if(isset($_GET["actualizar"])){
      $data = json_decode(file_get_contents('php://input'), true); 
       $ctl = new ControllerEmpleado();
       $result = $ctl::updateEmpleado($data);
       echo json_encode($result);
    }
      break;
  case 'GET':
    if(empty($_GET)){
      $empleados = ControllerEmpleado::getEmpleados();
      echo json_encode($empleados);
      exit();
    }else {
      $data = $_GET;
      $result = ControllerEmpleado::getEmpleado($data);
      echo json_encode($result);
      exit();
    }
    break;
}
