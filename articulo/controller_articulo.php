<?php 
class ControllerArticulo {
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
            $articulo->estatus = $data['estatus'];
        
            $conexion = new Conexion();
            $db = $conexion->getConexion();

            //$db->beginTransaction();

            $query = "INSERT INTO articulo VALUES (null , :id_categoria ,:id_empresa ,:id_impuesto ,:id_color ,:id_vendido_por ,:nombre,:descripcion ,:disponible ,:precio ,:coste ,:referencia ,:codigo_barras ,:imagen ,:estatus)";
            
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
            $statement->bindParam(":estatus",$articulo->estatus);

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

}

?>