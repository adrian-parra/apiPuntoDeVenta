<?php
class ControllerHistorialInventario {

    public static function getHistorial(){
        try{
            $db = Conexion::getConexionBd();

            $query = "select historial_de_inventario.referencia_id , DATE_FORMAT(historial_de_inventario.fecha_hora ,'%d %b %Y %H:%i') as fecha_hora ,historial_de_inventario.ajuste ,historial_de_inventario.stock_final ,articulo.nombre ,empleado.nombre as nombre_empleado,motivo_historial_inventario.nombre as nombre_motivo from historial_de_inventario ,articulo ,empleado ,motivo_historial_inventario WHERE historial_de_inventario.id_articulo = articulo.id and historial_de_inventario.id_motivo = motivo_historial_inventario.id and historial_de_inventario.id_empleado = empleado.id";
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
    public static function addHistorial($data){
        try{
            $idArticulo = $data['id_articulo'];
            $idEmpleado = $data['id_empleado'];
            $idMotivo = $data['id_motivo'];
            $referenciaId = $data['referencia_id'];
            $ajusteStock = $data['ajuste'];
            $stockFinal = $data['stock_final'];
            $idEmpresa = $data['id_empresa'];

            $query = "insert into historial_de_inventario values(null,:id_articulo ,:id_empresa,:id_empleado,:id_motivo ,:referencia_id ,now() ,:ajuste ,:stock_final)";

            $db = Conexion::getConexionBd();

            $statement = $db->prepare($query);
            $statement->bindParam(":id_articulo", $idArticulo);
            $statement->bindParam(":id_empleado", $idEmpleado);
            $statement->bindParam(":id_empresa", $idEmpresa);
            $statement->bindParam(":id_motivo", $idMotivo);
            $statement->bindParam(":referencia_id", $referenciaId);
            $statement->bindParam(":ajuste", $ajusteStock);
            $statement->bindParam(":stock_final", $stockFinal);

           
            $statement->execute();


          
            $options = array("0"=>true);

            return $options;
        }catch(PDOException $e){
            return $e->errorInfo;
        }
    }
}

?>