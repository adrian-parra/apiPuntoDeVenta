<?php
class ControllerCategoria
{
    private $nombre;

   
    public function __construct($Nombre)
    {
        $this->nombre = $Nombre;
      
    }

    public static function getCategoria($data){
        try{

            $id = $data['id'];
            $db = Conexion::getConexionBd();

            $query = "select * from categoria_articulo where id=:id";

            $statement = $db->prepare($query);
            $statement->bindParam(":id", $id);
            $statement->execute();
            while($row = $statement->fetch()) {
               $list[] = array(
                     "id" => $row['id'],
                     "nombre" => $row['nombre']);
            }//fin del ciclo while 
    
            return $list[0];
        }catch(PDOException $e){
            return $e->errorInfo;
        }
    }

    public static function getCategorias(){
        try{

            $db = Conexion::getConexionBd();

            $query = "select * from categoria_articulo";

            $statement = $db->prepare($query);
            $statement->execute();
            while($row = $statement->fetch()) {
               $list[] = array(
                     "id" => $row['id'],
                     "nombre" => $row['nombre']);
            }//fin del ciclo while 
    
            return $list;

        }catch(PDOException $e){
            return $e->errorInfo;
        }
    }


    public static function deleteCategoria($id){
        try{
            $conexion = new Conexion();
            $db = $conexion->getConexion();

            $query = "delete from categoria where id = ?";
            $statement = $db->prepare($query);
            $statement->execute([$id]);

        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }

    
    public function addCategoria()
    {
        try {
            $conexion = new Conexion();
            $db = $conexion->getConexion();

           // $db->beginTransaction();

            $query = "INSERT INTO categoria_articulo VALUES (null , :nombre)";

            $statement = $db->prepare($query);
            $statement->bindParam(":nombre", $this->nombre);
           
            $statement->execute();


          
            $options = array("0"=>true);

            return $options;
        } catch (PDOException $e) {
            //EL VALOR DE AUTOINCREMENTO DE LA TABLA empresa
            //SE INCREMENTA CUANDO HAY UN ERROR AL INSERTAR 
            //ESO NO TIENE QUE PASAR 

            //LOGICA PARA RESTARLE UNO AL VALOR
            //DE AUTOINCREMENTO
            

            //RETORNO UN ARRAY CON DATOS DEL ERROR(pdoexception)
            return $e->errorInfo;
        }
    }
}
