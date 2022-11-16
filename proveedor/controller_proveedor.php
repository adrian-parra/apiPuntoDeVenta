<?php 
class ControllerProveedor{

    public static function getProveedores(){
        try{
            $db = Conexion::getConexionBd();

            $query = "select * from proveedor";

            $statement = $db->prepare($query);
            $statement->execute();

            $list = array();
            while($row = $statement->fetchObject()) {

                $list[] = $row;
            }

            return $list;
        }catch(PDOException $e){
            return $e->errorInfo;
        }
    }

    public function addProveedor($data){
        try{
            //DECLARACION DE OBJETO ANONIMO
            $proveedor = new stdClass;
            $proveedor->idEmpresa = $data['id_empresa'];
            $proveedor->nombre = $data['nombre'];
            $proveedor->correo = $data['correo'];
            $proveedor->telefono = $data['telefono'];
            $proveedor->direccion = $data['direccion'];
            $proveedor->ciudad = $data['ciudad'];
            $proveedor->estado = $data['estado'];
            $proveedor->codigoPostal = $data['codigo_postal'];
            $proveedor->nota = $data['nota'];
            $proveedor->estatus = $data['estatus'];

            $proveedor->sitioWeb = $data['sitio_web'];

            $conexion = new Conexion();
            $db = $conexion->getConexion();

            //$db->beginTransaction();

            $query = "INSERT INTO proveedor VALUES (null ,:id_empresa, :nombre ,:correo,:telefono ,:sitio_web ,:direccion ,:ciudad ,:estado ,:codigo_postal ,:nota ,:estatus)";
            
            $statement = $db->prepare($query);
            $statement->bindParam(":nombre",$proveedor->nombre);
            $statement->bindParam(":id_empresa",$proveedor->idEmpresa);
            $statement->bindParam(":correo", $proveedor->correo);
            $statement->bindParam(":telefono",$proveedor->telefono);
            $statement->bindParam(":sitio_web",$proveedor->sitioWeb);
            $statement->bindParam(":direccion",$proveedor->direccion);
            $statement->bindParam(":ciudad",$proveedor->ciudad);
            $statement->bindParam(":estado",$proveedor->estado);
            $statement->bindParam(":codigo_postal",$proveedor->codigoPostal);
            $statement->bindParam(":nota",$proveedor->nota);
            $statement->bindParam(":estatus",$proveedor->estatus);

            $statement->execute();

            $options = array("0"=>true);

            return $options;

        }catch(PDOException $e){
               //EL VALOR DE AUTOINCREMENTO DE LA TABLA cliente
            //SE INCREMENTA CUANDO HAY UN ERROR AL INSERTAR 
            //ESO NO TIENE QUE PASAR 

            //LOGICA PARA RESTARLE UNO AL VALOR
            //DE AUTOINCREMENTO
           // $db->rollBack();//SE ENCARGA DE ANULAR LA ULTIMA TRANSACCION
            return $e->errorInfo;
        }
    }

}

?>