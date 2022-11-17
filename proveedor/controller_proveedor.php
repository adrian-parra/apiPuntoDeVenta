<?php
class ControllerProveedor
{

    public static function updateProveedor($data){
        try {
            $id = $data['id'];
            $nombre = $data['nombre'];
            $correo = $data['correo'];
            $telefono = $data['telefono'];
            $sitioWeb = $data['sitio_web'];
            $direccion = $data['direccion'];
            $ciudad = $data['ciudad'];
            $estado = $data['estado'];
            $codigoPostal = $data['codigo_postal'];
            $nota = $data['nota'];

            $db = Conexion::getConexionBd();

            $query = "update proveedor set nombre=:nombre ,correo= :correo ,telefono = :telefono ,sitio_web=:sitio_web ,direccion = :direccion ,ciudad=:ciudad ,estado=:estado,codigo_postal=:codigo_postal,nota=:nota WHERE id = :id";
            $statement = $db->prepare($query);
            $statement->bindParam(":id", $id);
            $statement->bindParam(":nombre", $nombre);
            $statement->bindParam(":correo", $correo);
            $statement->bindParam(":telefono", $telefono);
            $statement->bindParam(":sitio_web", $sitioWeb);
            $statement->bindParam(":direccion", $direccion);
            $statement->bindParam(":ciudad", $ciudad);
            $statement->bindParam(":estado", $estado);
            $statement->bindParam(":codigo_postal", $codigoPostal);
            $statement->bindParam(":nota", $nota);


            $statement->execute();

            $options = array("0" => true);

            return $options;

        }catch(PDOException $e){
            return $e->errorInfo;
        }
    }

    public static function getProveedor($data)
    {

        try {
            $id = $data['id'];

            $db = Conexion::getConexionBd();

            $query = "SELECT id ,nombre ,correo ,telefono,sitio_web ,direccion ,ciudad ,estado ,codigo_postal ,nota FROM proveedor where id = :id";

            $statement = $db->prepare($query);
            $statement->bindParam(":id", $id);

            $statement->execute();

            $list = array();
            while ($row = $statement->fetchObject()) {

                $list[0] = $row;
            }

            return $list[0];
        } catch (PDOException $e) {
            return $e->errorInfo;
        }
    }

    public static function getProveedores()
    {
        try {
            $db = Conexion::getConexionBd();

            $query = "select * from proveedor";

            $statement = $db->prepare($query);
            $statement->execute();

            $list = array();
            while ($row = $statement->fetchObject()) {

                $list[] = $row;
            }

            return $list;
        } catch (PDOException $e) {
            return $e->errorInfo;
        }
    }

    public function addProveedor($data)
    {
        try {
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


            $proveedor->sitioWeb = $data['sitio_web'];

            $conexion = new Conexion();
            $db = $conexion->getConexion();

            //$db->beginTransaction();

            $query = "INSERT INTO proveedor VALUES (null ,:id_empresa, :nombre ,:correo,:telefono ,:sitio_web ,:direccion ,:ciudad ,:estado ,:codigo_postal ,:nota ,'a')";

            $statement = $db->prepare($query);
            $statement->bindParam(":nombre", $proveedor->nombre);
            $statement->bindParam(":id_empresa", $proveedor->idEmpresa);
            $statement->bindParam(":correo", $proveedor->correo);
            $statement->bindParam(":telefono", $proveedor->telefono);
            $statement->bindParam(":sitio_web", $proveedor->sitioWeb);
            $statement->bindParam(":direccion", $proveedor->direccion);
            $statement->bindParam(":ciudad", $proveedor->ciudad);
            $statement->bindParam(":estado", $proveedor->estado);
            $statement->bindParam(":codigo_postal", $proveedor->codigoPostal);
            $statement->bindParam(":nota", $proveedor->nota);


            $statement->execute();

            $options = array("0" => true);

            return $options;
        } catch (PDOException $e) {
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
