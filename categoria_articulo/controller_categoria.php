<?php
class ControllerCategoria
{
    private $nombre;

   
    public function __construct($Nombre)
    {
        $this->nombre = $Nombre;
      
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

            $query = "INSERT INTO categoria VALUES (null , :nombre)";

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
