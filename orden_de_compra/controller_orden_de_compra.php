<?php
class ControllerOrdenDeCompra {

    public static function updateOrdenCompra($data){
        try{
            $id = $data['id'];
            $recibido = $data['recibido'];
            $estado = $data['estado'];

            $db = Conexion::getConexionBd();
            
            $query = "update orden_de_compra set estado = :estado,recibido = :recibido WHERE id = :id";

            $statement = $db->prepare($query);
            $statement->bindParam(":id", $id);
            $statement->bindParam(":recibido", $recibido);
            $statement->bindParam(":estado", $estado);

            $statement->execute();

            $options = array('0'=>true);

            return $options;

        }catch(PDOException $e){
            return $e->errorInfo;
        }
    }
    
    public static function getOrdenCompra($data){
        try{

            $id = $data['id'];
            $db = Conexion::getConexionBd();

            $query = "SELECT 
            orden_de_compra.id,
            orden_de_compra.estado,
            orden_de_compra.recibido,
            DATE_FORMAT( orden_de_compra.fecha_orden ,'%d %b %Y') as fecha_orden,
            DATE_FORMAT(orden_de_compra.fecha_espera ,'%d %b %Y') as fecha_espera ,
            orden_de_compra.total ,
            (SELECT sum(cantidad) from detalle_orden_de_compra where orden_de_compra.id = id_orden_de_compra) as total_articulos,
            proveedor.nombre as proveedor ,
            empleado.nombre as empleado
            FROM 
            orden_de_compra ,
            proveedor ,
            empleado
            WHERE 
            orden_de_compra.id_proveedor = proveedor.id and orden_de_compra.id_empleado = empleado.id AND
            orden_de_compra.id = :id";

            $statement = $db->prepare($query);
            $statement->bindParam(":id", $id);
            $statement->execute();

            $list = array();
            while($row = $statement->fetchObject()) {

                $list[] = $row;
            
             }//fin del ciclo while 
     
             return $list[0];

         
        }catch(PDOException $e){
            return $e->errorInfo;
        }
    }

    public static function getOrdenDeCompra(){
        try{
            $db = Conexion::getConexionBd();

            $query = "SELECT 
            orden_de_compra.id,
            orden_de_compra.estado,
            orden_de_compra.recibido,
            DATE_FORMAT( orden_de_compra.fecha_orden ,'%d %b %Y') as fecha_orden,
            DATE_FORMAT(orden_de_compra.fecha_espera ,'%d %b %Y') as fecha_espera ,
            orden_de_compra.total ,
            (SELECT sum(cantidad) from detalle_orden_de_compra where orden_de_compra.id = id_orden_de_compra) as total_articulos,
            proveedor.nombre as proveedor 
            FROM 
            orden_de_compra ,
            proveedor 
            WHERE 
            orden_de_compra.id_proveedor = proveedor.id";
            $statement = $db->prepare($query);
            $statement->execute();

            $list = array();
            while($row = $statement->fetchObject()) {

                
            if($row->id != null){
                $list[] = $row;
            }

           
               
             }//fin del ciclo while 
     
             return $list;
        }catch(PDOException $e){
            return $e->errorInfo;
        }
    }

    public static function addDetalleOrdenDeCompra($data){
        try{
            $idArticulo = $data['id_articulo'];
            $idOrdenDeCompra = $data['id_orden_de_compra'];
            $cantidad = $data['cantidad'];
            $costo = $data['costo'];
            $total = $data['total'];
            

            $db = Conexion::getConexionBd();

            $query = "insert into detalle_orden_de_compra values (null ,:id_articulo ,:id_orden_de_compra ,:cantidad , :costo ,:total ,0)";

            $statement = $db->prepare($query);
            $statement->bindParam(":id_articulo", $idArticulo);
            $statement->bindParam(":id_orden_de_compra", $idOrdenDeCompra);
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
    public static function addOrdenDeCompra($data){
        try{
            $idProveedor = $data['id_proveedor'];
            $idTienda = $data['id_tienda'];
            $fechaOrden = $data['fecha_orden'];
            $fechaEspera = $data['fecha_espera'];
            $total = $data['total'];
            $anotaciones = $data['anotaciones'];
            $idEmpleado = $data['id_empleado'];

            $db = Conexion::getConexionBd();

            $query = "insert into orden_de_compra values (null ,:id_proveedor ,:id_empleado ,:id_tienda ,'pendiente' , 0 ,:fecha_orden ,:fecha_espera ,:total ,:anotaciones)";

            $statement = $db->prepare($query);
            $statement->bindParam(":id_proveedor", $idProveedor);
            $statement->bindParam(":id_empleado", $idEmpleado);

            $statement->bindParam(":id_tienda", $idTienda);
            $statement->bindParam(":fecha_orden", $fechaOrden);
            $statement->bindParam(":fecha_espera", $fechaEspera);
            $statement->bindParam(":total", $total);
            $statement->bindParam(":anotaciones", $anotaciones);

           
            $statement->execute();


          
            $options = array("0"=>true ,"id" =>$db->lastInsertId());

            return $options;

        }catch(PDOException $e){
            return $e->errorInfo;
        }
    }
}



?>