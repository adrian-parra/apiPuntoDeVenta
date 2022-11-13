<?php 
class ControllerInventario {
    public static function addArticuloInventario($data ,$idarticulo){
        try{
            $idArticulo = $idarticulo;
            $stock = $data['stock'];
            $stockBajo = $data['stock_bajo'];
            $stockOptimo = $data['stock_optimo'];
            $idProveedor = $data['id_proveedor'];
            $compraDefecto = $data['compra_defecto'];

            $db = Conexion::getConexionBd();

            $query = "insert into inventario values (null ,:id_articulo ,:stock ,:stock_bajo, :stock_optimo , :id_proveedor , :compra_defecto)";
            $statement = $db->prepare($query);
            $statement->bindParam(":id_articulo",$idArticulo);
            $statement->bindParam(":stock",$stock);
            $statement->bindParam(":stock_bajo",$stockBajo);
            $statement->bindParam(":stock_optimo",$stockOptimo);
            $statement->bindParam(":id_proveedor",$idProveedor);
            $statement->bindParam(":compra_defecto",$compraDefecto);

            $statement->execute();

            $options = array("0"=>true);

            return $options;


        }catch(PDOException $e){
            return $e->errorInfo;
        }
    }
}
?>