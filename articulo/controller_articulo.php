<?php 
class ControllerArticulo {

    public static function getArticulo($data){
            try{
                $id = $data['id'];

                $db = Conexion::getConexionBd();

                $query = "SELECT articulo.id, articulo.nombre ,articulo.descripcion ,articulo.disponible , articulo.id_vendido_por as vendido_por ,articulo.ref ,articulo.codigo_barras ,inventario.compra_defecto ,articulo.precio ,articulo.coste, articulo.id_categoria as nombre_categoria ,inventario.stock ,inventario.stock_bajo ,inventario.stock_optimo ,articulo.ruta_imagen from articulo ,categoria_articulo ,inventario where articulo.id = inventario.id_articulo and articulo.id_categoria = categoria_articulo.id and articulo.id = :id";
                
                $statement = $db->prepare($query);
                $statement->bindParam(":id",$id);
                $statement->execute();

                $list = array();
                while($row = $statement->fetchObject()) {
                   $list[0] = $row;
                }//fin del ciclo while 
        
                return $list[0];

            }catch(PDOException $e){
                return $e->errorInfo;
            }
    }

    public static function getArticulos(){
        try{
            $db = Conexion::getConexionBd();

            $query = "SELECT articulo.id, articulo.nombre,articulo.precio ,articulo.coste, categoria_articulo.nombre as nombre_categoria ,inventario.stock ,inventario.stock_bajo ,inventario.stock_optimo from articulo ,categoria_articulo ,inventario where articulo.id = inventario.id_articulo and articulo.id_categoria = categoria_articulo.id";
            $statement = $db->prepare($query);
            $statement->execute();

            $list = array();
            while($row = $statement->fetch()) {
               $list[] = array(
                     "id" => $row['id'],
                     "precio" => $row['precio'],
                     "coste" => $row['coste'],
                     "stock" => $row['stock'],
                     "stock_bajo" => $row['stock_bajo'],
                     "stock_optimo" => $row['stock_optimo'],
                     "nombre_categoria" => $row['nombre_categoria'],
                     "nombre" => $row['nombre']);
            }//fin del ciclo while 
    
            return $list;
        }catch(PDOException $e){
            return $e->errorInfo;
        }
    }
    public function addArticulo($data){
        

        try{
            //DECLARACION DE OBJETO ANONIMO
            $articulo = new stdClass;
            $articulo->idEmpresa = $data['id_empresa'];
            $articulo->idImpuesto = $data['id_impuesto'];
            $articulo->idColor = $data['id_color'];
            $articulo->idVendidoPor = $data['id_vendido_por'];
            $articulo->disponible = $data['disponible'];

            $articulo->nombre = $data['nombre'];
            $articulo->idCategoria = $data['id_categoria'];
            $articulo->descripcion = $data['descripcion'];
            $articulo->precio = $data['precio'];
            $articulo->coste = $data['coste'];
            $articulo->referencia = $data['ref'];
            $articulo->codigoBarras = $data['codigo_barras'];
            $articulo->imagen = $data['ruta_imagen'];
       
        
            $conexion = new Conexion();
            $db = $conexion->getConexion();

            //$db->beginTransaction();

            $query = "INSERT INTO articulo VALUES (null , :id_categoria ,:id_empresa ,:id_impuesto ,:id_color ,:id_vendido_por ,:nombre,:descripcion ,:disponible ,:precio ,:coste ,:referencia ,:codigo_barras ,:imagen ,'a')";
            
            $statement = $db->prepare($query);
            $statement->bindParam(":id_empresa",$articulo->idEmpresa);
            $statement->bindParam(":id_impuesto",$articulo->idImpuesto);
            $statement->bindParam(":id_color",$articulo->idColor);
            $statement->bindParam(":id_vendido_por",$articulo->idVendidoPor);
            $statement->bindParam(":disponible",$articulo->disponible);

            $statement->bindParam(":nombre",$articulo->nombre);
            $statement->bindParam(":id_categoria", $articulo->idCategoria);
            $statement->bindParam(":descripcion",$articulo->descripcion);
            $statement->bindParam(":precio",$articulo->precio);
            $statement->bindParam(":coste",$articulo->coste);
            $statement->bindParam(":referencia",$articulo->referencia);
            $statement->bindParam(":codigo_barras",$articulo->codigoBarras);
            $statement->bindParam(":imagen",$articulo->imagen);
         

            $statement->execute();

            return ControllerInventario::addArticuloInventario($data ,$db->lastInsertId());

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

}

?>