<?php 
class ControllerDetalleVenta
{

    public static function getDetallesVenta($data){
        try{
            $id = $data['id'];

            $db = Conexion::getConexionBd();

            $query = "select detalle_venta.* ,articulo.nombre as nombre_articulo from detalle_venta ,articulo where id_venta = '$id' and detalle_venta.id_articulo = articulo.id";

            $statement = $db->prepare($query);

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
    public static function addDetalleVenta($data){

        try{
            $idVenta = $data['id_venta'];
            $idArticulo = $data['id_articulo'];
            $cantidad = $data['cantidad'];
            $costo = $data['costo'];
            $total = $data['total'];
           

            $db = Conexion::getConexionBd();
        
            $query = "insert into detalle_venta values (null,:id_venta ,:id_articulo,:cantidad,:costo,:total)";

            $statement = $db->prepare($query);
            $statement->bindParam(":id_venta", $idVenta);
            $statement->bindParam(":id_articulo", $idArticulo);
            $statement->bindParam(":cantidad", $cantidad);
            $statement->bindParam(":costo", $costo);
            $statement->bindParam(":total", $total);

            $statement->execute();


          
            $options = array("0"=>true);

            return $options;

        }catch(PDOException $e){
            return $e->errorInfo;
        }

    }

}

?>