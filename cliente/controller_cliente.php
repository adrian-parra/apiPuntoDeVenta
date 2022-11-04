<?php 
class ControllerCliente {



/*
    function __construct() {
        $this->conexionBd = Conexion::getConexionBd();
    }*/

    public static function addCliente($data){


        try{
            //DECLARACION DE OBJETO ANONIMO
            $cliente = new stdClass;
            $cliente->nombre = $data['nombre'];
            $cliente->correo = $data['correo'];
            $cliente->telefono = $data['telefono'];
            $cliente->direccion = $data['direccion'];
            $cliente->ciudad = $data['ciudad'];
            $cliente->estado = $data['estado'];
            $cliente->codigoPostal = $data['codigo_postal'];
            $cliente->nota = $data['nota'];
            $cliente->estatus = "a";

            $cliente->idEmpresa = $data['id_empresa'];

            $cliente->primeraVisita = null;
            $cliente->ultimaVisita = null;
            $cliente->visitas = 0;
            $cliente->gastoTotal = 0.0;




            $conexion = new Conexion();
            $db = $conexion->getConexion();

            //$db->beginTransaction();

            $query = "INSERT INTO cliente VALUES (null ,:id_empresa , :nombre,:correo,:telefono ,:direccion ,:ciudad ,:estado ,:codigo_postal ,:nota ,:primera_visita ,:ultima_visita,:visitas ,:gasto_total ,:estatus)";
            
            $statement = $db->prepare($query);
            $statement->bindParam(":id_empresa",$cliente->idEmpresa);
            $statement->bindParam(":nombre",$cliente->nombre);
            $statement->bindParam(":correo", $cliente->correo);
            $statement->bindParam(":telefono",$cliente->telefono);
            $statement->bindParam(":direccion",$cliente->direccion);
            $statement->bindParam(":ciudad",$cliente->ciudad);
            $statement->bindParam(":estado",$cliente->estado);
            $statement->bindParam(":codigo_postal",$cliente->codigoPostal);
            $statement->bindParam(":nota",$cliente->nota);
            $statement->bindParam(":estatus",$cliente->estatus);

            $statement->bindParam(":primera_visita",$cliente->primeraVisita);
            $statement->bindParam(":ultima_visita",$cliente->ultimaVisita);
            $statement->bindParam(":visitas",$cliente->visitas);
            $statement->bindParam(":gasto_total",$cliente->gastoTotal);


            $statement->execute();

            //$db->commit();

            $options = array("0"=>true);

            return $options;

        }catch(PDOException $e){
               //EL VALOR DE AUTOINCREMENTO DE LA TABLA cliente
            //SE INCREMENTA CUANDO HAY UN ERROR AL INSERTAR 
            //ESO NO TIENE QUE PASAR 

            //LOGICA PARA RESTARLE UNO AL VALOR
            //DE AUTOINCREMENTO
            //$db->rollBack();//SE ENCARGA DE ANULAR LA ULTIMA TRANSACCION
            return $e->errorInfo;
        }
    }


    public static function getClientes(){
        try{
            $list = array();
            $db = Conexion::getConexionBd();
            $query = "SELECT * FROM cliente";
            //$statement = $this->conexionBd->prepare($query);
            $statement = $db->prepare($query);
            $statement->execute();
            while($row = $statement->fetch()) {
               $list[] = array(
                     "id" => $row['id'],
                     "nombre" => $row['nombre'],
                     "correo" => $row['correo'],
                     "telefono" => $row['telefono'],
                     "direccion" => $row['direccion'],
                     "ciudad" => $row['ciudad'] ,
                    
                     "estado" => $row['estado'],
                     "codigo_postal" => $row['codigo_postal'],
                     "nota" => $row['nota'],
                     "primera_visita" => $row['primera_visita'],
                     "ultima_visita" => $row['ultima_visita'],
                     "visitas" => $row['visitas'],
                     "gasto_total" => $row['gasto_total'],);
            }//fin del ciclo while 
    
            return $list;
        }catch(PDOException $e){
            $e->errorInfo;
        }
    }

}

?>