<?php
class ControllerEmpleado{

    public static function updateEmpleado($data){
        try{
            $id = $data['id'];
            $nombre = $data['nombre'];
            $telefono = $data['telefono'];
            $correo = $data['correo'];
            $id_rol = $data['id_rol'];


            $conexion = new Conexion();

            $db = $conexion->getConexion();
            $query = "update empleado ,usuario set empleado.nombre=:nombre ,empleado.telefono = :telefono , usuario.id_rol =:id_rol ,usuario.correo = :correo  where empleado.id = :id and empleado.id_usuario = usuario.id";
            $statement= $db->prepare($query);
            $statement->bindParam(":id", $id);
            $statement->bindParam(":nombre", $nombre);
            $statement->bindParam(":telefono", $telefono);
            $statement->bindParam(":correo", $correo); 
            $statement->bindParam(":id_rol", $id_rol); 

            $statement->execute();

            $options = array("0"=>true);

            return $options;
        }catch(PDOException $e){
             //RETORNO UN ARRAY CON DATOS DEL ERROR(pdoexception)
             return $e->errorInfo;
        }
    }

    public static function getEmpleado($data){
        $id = $data['id'];
        $list = array();
        $conexion = new Conexion();
        $db = $conexion->getConexion();
        $query = "SELECT empleado.id, empleado.telefono ,empleado.nombre ,usuario.correo ,rol.nombre as rol FROM empleado ,usuario ,rol WHERE empleado.id_usuario = usuario.id AND usuario.id_rol = rol.id and empleado.id = :id";
        $statement = $db->prepare($query);
        $statement->bindParam(':id', $id); 
        $statement->execute();
        while($row = $statement->fetch()) {
              $list[] = array(
                    "id" => $row['id'],
                     "telefono" => $row['telefono'],
                     "correo" => $row['correo'],
                     "nombre" => $row['nombre'],
                     "rol" => $row['rol'] );
              }//fin del ciclo while 
    
        return $list[0];
    }

    public static function getEmpleados(){
        try{
            $list = array();
            $conexion = new Conexion();
            $db = $conexion->getConexion();
            $query = "SELECT empleado.id, empleado.telefono ,empleado.nombre ,usuario.correo ,rol.nombre as rol FROM empleado ,usuario ,rol WHERE empleado.id_usuario = usuario.id AND usuario.id_rol = rol.id";
            $statement = $db->prepare($query);
            $statement->execute();
            while($row = $statement->fetch()) {
               $list[] = array(
                     "id" => $row['id'],
                     "telefono" => $row['telefono'],
                     "correo" => $row['correo'],
                     "nombre" => $row['nombre'],
                     "rol" => $row['rol'] );
            }//fin del ciclo while 
    
            return $list;
    
          }catch(PDOException $e){
            echo $e->getMessage();
          }
    }

    public function addEmpleado($data){
        
        try{
            //DECLARACION DE OBJETO ANONIMO
            $empleado = new stdClass;
            $empleado->idUser = $data['id_usuario'];
            $empleado->name = $data['nombre'];
            $empleado->phone = $data['telefono'];
            $empleado->status = $data['estatus'];
            
            


            //SI EL ID USUARIO TRAE UN VALOR NULL 
            //ESA ACCION FUE DESDE EL FORM AGREGAR UN EMPLEADO.
            if($data['id_usuario'] == null){
                $empleado->idBusiness = $data['id_nombre_empresa'];
                $empleado->idRol = $data['id_rol'];
                $empleado->email = $data['correo'];
                $empleado->password = $data['clave'];


                $ctl = new ControllerUsuario();

                $properyUsusario = array("id_nombre_empresa"=>$empleado->idBusiness ,"id_rol"=>$empleado->idRol,"correo"=>$empleado->email ,"clave"=>$empleado->password ,"estatus"=>$empleado->status);

                
                $result = $ctl->addUsuario($properyUsusario);
                

                if($result[0] !== true){
                    return $result;
                }

                $empleado->idUser = $result[1];

            }
          

            $conexion = new Conexion();
            $db = $conexion->getConexion();
            
            
            $query = "INSERT INTO empleado VALUES (null , :idUser,:name,:phone ,:status)";
            
            $statement = $db->prepare($query);
            $statement->bindParam(":idUser",$empleado->idUser);
            $statement->bindParam(":name", $empleado->name);
            $statement->bindParam(":phone",$empleado->phone);
            $statement->bindParam(":status",$empleado->status);
           
            $statement->execute();

            $options = array("0"=>true);

          
            return $options;


        } catch (PDOException $e) {
            //EL VALOR DE AUTOINCREMENTO DE LA TABLA empleado
            //SE INCREMENTA CUANDO HAY UN ERROR AL INSERTAR 
            //ESO NO TIENE QUE PASAR 

            //LOGICA PARA RESTARLE UNO AL VALOR
            //DE AUTOINCREMENTO

            //OBTENGO EL VALOR MAXIMO DEL ID
            $query = "select max(id) as maxid from empleado";
            $stm = $db->query($query);
            //CONVIERTO EL RESULT A ARRAY DEL VALOR ID 
            $result = $stm->fetchall(PDO::FETCH_ASSOC);

            //ACTUALIZO EL VALOR DE AUTOINCREMENTO POR EL VALOR MAXIMO OBTENIDO
            $query = "ALTER TABLE empleado AUTO_INCREMENT = ".$result[0]['maxid'];
            $stm = $db->query($query);

            //CUANDO ALLA UNA EXCEPTION SE TIENE QUE ELIMINAR EL ULTIMO
            //REGISTRO EN USUARIO..
            ControllerUsuario::deleteUsuario($empleado->idUser);

            //RETORNO UN ARRAY CON DATOS DEL ERROR(pdoexception)
            return $e->errorInfo;
        }
    }

}
