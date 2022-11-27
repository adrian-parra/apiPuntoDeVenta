<?php 
class ControllerVenta


{   
    public static function getReciboVenta($data){
        try{

            $id = $data['id'];
            $colaborador = $data['colaborador'];


            //VERIFICAR SI NO SE HACE NINGUN FILTRADO DE DATOS 
            if($id == "all" && $colaborador == "all"){
                $query = "SELECT 
                venta.id ,venta.total ,venta.cambio ,DATE_FORMAT(venta.fecha ,'%d %b %Y %H:%i') as fecha ,venta.tipo_venta ,
                empleado.nombre as empleado ,
                (SELECT nombre from cliente where venta.id_cliente = id) as cliente ,
                tipo_pago.nombre as tipo_pago,
                empresa.nombre as empresa
                from 
                venta ,empleado ,cliente ,tipo_pago ,empresa
                where 
                venta.id_empleado = empleado.id AND
                venta.id_tipo_pago = tipo_pago.id and
                venta.id_empresa = empresa.id";
            }else if($id != "all" && $colaborador == "all"){
                $query = "SELECT 
                venta.id ,venta.total ,venta.cambio ,DATE_FORMAT(venta.fecha ,'%d %b %Y %H:%i') as fecha ,venta.tipo_venta ,
                empleado.nombre as empleado ,
                (SELECT nombre from cliente where venta.id_cliente = id) as cliente ,
                tipo_pago.nombre as tipo_pago,
                empresa.nombre as empresa
                from 
                venta ,empleado ,cliente ,tipo_pago ,empresa
                where 
                venta.id_empleado = empleado.id AND
                venta.id_tipo_pago = tipo_pago.id and
                venta.id_empresa = empresa.id AND
                venta.id = '$id'";
            }else if($id == "all" && $colaborador != "all"){
                $query = "SELECT 
                venta.id ,venta.total ,venta.cambio ,DATE_FORMAT(venta.fecha ,'%d %b %Y %H:%i') as fecha ,venta.tipo_venta ,
                empleado.nombre as empleado ,
                (SELECT nombre from cliente where id= venta.id_cliente) as cliente,
                tipo_pago.nombre as tipo_pago,
                empresa.nombre as empresa
                from 
                venta ,empleado,cliente ,tipo_pago ,empresa
                where 
                empleado.id = '$colaborador' AND
                venta.id_empleado = '$colaborador' and
                venta.id_tipo_pago = tipo_pago.id and
                venta.id_empresa = empresa.id";
            }

            $db = Conexion::getConexionBd();
            
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
    
    public static function updateStockArticuloInventario($data){
        try{
            $idArticulo = $data['id_articulo'];
            $cantidad = $data['cantidad'];

            $db = Conexion::getConexionBd();

            $query = "update inventario set stock = stock - :cantidad where id_articulo = :id_articulo";
            
            $statement = $db->prepare($query);
            $statement->bindParam(":cantidad", $cantidad);
            $statement->bindParam(":id_articulo", $idArticulo);

            $statement->execute();

            $options = array('0'=>true);

            return $options;


        }catch(PDOException $e){
            return $e->errorInfo;
        }
    }

    public static function addVenta($data){

        try{
            $idEmpleado = $data['id_empleado'];
            $idEmpresa = $data['id_empresa'];
            $idCliente = $data['id_cliente'];
            $idTipoPago = $data['id_tipo_pago'];
            $tipoVenta = $data['tipo_venta'];
            $total = $data['total'];
            $cambio = $data['cambio'];

            $db = Conexion::getConexionBd();
        
            $query = "insert into venta values (null,:id_empresa ,:id_empleado,:id_cliente,:id_tipo_pago,:tipo_venta ,:total,:cambio , now())";

            $statement = $db->prepare($query);
            $statement->bindParam(":id_empresa", $idEmpresa);
            $statement->bindParam(":id_empleado", $idEmpleado);

            $statement->bindParam(":id_cliente", $idCliente);
            $statement->bindParam(":id_tipo_pago", $idTipoPago);
            $statement->bindParam(":tipo_venta", $tipoVenta);
            $statement->bindParam(":total", $total);
            $statement->bindParam(":cambio", $cambio);

            $statement->execute();


          
            $options = array("0"=>true ,"id" =>$db->lastInsertId());

            return $options;

        }catch(PDOException $e){
            return $e->errorInfo;
        }

    }

}

?>