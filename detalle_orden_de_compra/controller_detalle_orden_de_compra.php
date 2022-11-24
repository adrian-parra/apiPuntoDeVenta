<?php
    class ControllerDetalleOrdenDeCompra {

        public static function updateDetalleOrdenDeCompra($data){
            try{
                $id = $data['id'];
                $recibido= $data['recibido'];

                $db =Conexion::getConexionBd();

                $query = "UPDATE detalle_orden_de_compra set recibido =:recibido where id = :id";

                $statement = $db->prepare($query);
                $statement->bindParam(":id", $id);
                $statement->bindParam(":recibido", $recibido);

                $statement->execute();

                $option = array('0'=>true);

                return $option;
            }catch(PDOException $e){
                return $e->errorInfo;
            }
        }

        public static function getDetallesOrdeneDeCompra($data){
            try{

                $id = $data['id'];
                $db = Conexion::getConexionBd();

                $query = "SELECT detalle_orden_de_compra.cantidad ,detalle_orden_de_compra.costo ,detalle_orden_de_compra.total ,detalle_orden_de_compra.recibido ,detalle_orden_de_compra.id ,detalle_orden_de_compra.id_articulo ,articulo.nombre as articulo FROM detalle_orden_de_compra ,articulo WHERE detalle_orden_de_compra.id_articulo = articulo.id and detalle_orden_de_compra.id_orden_de_compra = :id";

                $statement = $db->prepare($query);
                $statement->bindParam(":id", $id);
                $statement->execute();
    
                $list = array();
                while($row = $statement->fetchObject()) {
                   $list[] = $row;
                 }//fin del ciclo while 
         
                 return $list;
     
            }catch(PDOException $e){
                return $e->errorInfo;
            }
        }
    }

?>