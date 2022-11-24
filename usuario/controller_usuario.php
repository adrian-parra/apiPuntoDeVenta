<?php
class ControllerUsuario{


    public static function verificarSesion($data){
       
        try{
              //DECLARACION DE OBJETO ANONIMO
         $usuario = new stdClass;
         $usuario->correo = $data['correo'];
         $usuario->clave = $data['clave'];

            $conexion = new Conexion();
            $db = $conexion->getConexion();

            $query = "SELECT usuario.* ,empresa.nombre as nombre_empresa ,rol.nombre as nombre_rol ,empleado.nombre ,empleado.id as id_empleado  FROM usuario ,empresa ,rol ,empleado WHERE usuario.correo = :correo and usuario.clave = :clave and usuario.id_nombre_empresa = empresa.id and usuario.id_rol = rol.id and usuario.id = empleado.id_usuario";
            
            $statement = $db->prepare($query);
            $statement->bindParam(":correo",$usuario->correo);
            $statement->bindParam(":clave",$usuario->clave);
            $statement->execute();

            $usuarioEncontrado = false;
            $list[] = array();
            while($row = $statement->fetch()) {
                $usuarioEncontrado = true;
                $list[0] = array(
                      "errors"=>false,
                      "id" => $row['id'],
                      "id_nombre_empresa" => $row['id_nombre_empresa'],
                      "id_rol" => $row['id_rol'],
                      "correo" => $row['correo'] ,
                      "nombre_empresa" => $row['nombre_empresa'] ,
                      "nombre_rol" => $row['nombre_rol'] ,
                      "id_empleado" => $row['id_empleado'],
                      "nombre" => $row['nombre'],
                     );
             }//fin del ciclo while 

             if(!$usuarioEncontrado){
                $options[0] = array("errors"=>true);
                return $options[0];
             }
             return $list[0];
                
                
             
           
        }catch(PDOException $e){
            return $e->errorInfo;
        }
    }

    public static function deleteUsuario($id){
        try{
            $conexion = new Conexion();
            $db = $conexion->getConexion();

            $query = "delete from usuario where id = ?";
            $statement = $db->prepare($query);
            $statement->execute([$id]);

        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }

    public function addUsuario($data){
        
        try{
            //DECLARACION DE OBJETO ANONIMO
            $usuario = new stdClass;
            $usuario->idNameBusiness = $data['id_nombre_empresa'];
           
            $usuario->idRol = $data['id_rol'];
            $usuario->email = $data['correo'];
            $usuario->password = $data['clave'];
            $usuario->status = $data['estatus'];

            $usuario->id = "";


            //INSERTO NOMBRE DE EMPRESA
            if($usuario->idNameBusiness == null){
                $usuario->nameBusiness = $data['nombre_empresa'];

                $ctl = new ControllerEmpresa($usuario->nameBusiness ,"a");
                $result = $ctl->addEmpresa();
                
                
                if($result[0] !== true){
                    return $result;
                }

                $usuario->idNameBusiness = $result[1];

             

                
            }
    
            $conexion = new Conexion();
            $db = $conexion->getConexion();
            
            
            $query = "INSERT INTO usuario VALUES (null , :idNameBusiness,:idRol,:email ,:password ,:status)";
            
            $statement = $db->prepare($query);
            $statement->bindParam(":idNameBusiness",$usuario->idNameBusiness);
            $statement->bindParam(":idRol",$usuario->idRol);
            $statement->bindParam(":email",$usuario->email);
            $statement->bindParam(":password",$usuario->password);
            $statement->bindParam(":status",$usuario->status);
            $statement->execute();

            //$options = array("0"=>true);
            $usuario->id = $db->lastInsertId();
            
          
           //return $options;


        } catch (PDOException $e) {
            //EL VALOR DE AUTOINCREMENTO DE LA TABLA USUARIO
            //SE INCREMENTA CUANDO HAY UN ERROR AL INSERTAR 
            //ESO NO TIENE QUE PASAR 

            //LOGICA PARA RESTARLE UNO AL VALOR
            //DE AUTOINCREMENTO

            //OBTENGO EL VALOR MAXIMO DEL ID
            $query = "select max(id) as maxid from usuario";
            $stm = $db->query($query);
            //CONVIERTO EL RESULT A ARRAY DEL VALOR ID 
            $result = $stm->fetchall(PDO::FETCH_ASSOC);

            //ACTUALIZO EL VALOR DE AUTOINCREMENTO POR EL VALOR MAXIMO OBTENIDO
            $query = "ALTER TABLE usuario AUTO_INCREMENT = ".$result[0]['maxid'];
            $stm = $db->query($query);

            //ELIMINO LA EMPRESA PREVIAMENTE INSERTADA
            if($data['id_nombre_empresa'] == null){
                ControllerEmpresa::deleteEmpresa($usuario->idNameBusiness);
            }
          

            //RETORNO UN ARRAY CON DATOS DEL ERROR(pdoexception)
            
            return $e->errorInfo;
        } //FIN DE TRY CATCH

            //CERRAR LA CONEXION A LA BD 
            $statement->closeCursor();
            $statement = null;
            $db=null;

            //CREAR UN EMPLEADO
            //SI ES IGUAL A NULL ESTA ACCION SE ESTA REALIZANDO 
            //DESDE EL FORM DE REGISTRO EN SISTEMA
            //POR LO TANTO SE AGREGA UN EMPLEADO CON ROL
            //DE PROPIETARIO
            if($data['id_nombre_empresa'] == null){
                $propertyUsuario = array("id_usuario"=>$usuario->id, "nombre"=>"Propietario", "telefono"=>null,"estatus"=>"a");

                $ctl = new ControllerEmpleado();
                $result = $ctl->addEmpleado($propertyUsuario);

                return $result;
            }else {

                $options = array("0"=>true,"1"=>$usuario->id);
                return $options;
            }
            

    }

}

?>