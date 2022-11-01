<?php
class ControllerEmpresa
{
    private $nombre;
    private $estatus;

   
    public function __construct($Nombre, $estatus)
    {
        $this->nombre = $Nombre;
        $this->estatus = $estatus;
    }


    public static function deleteEmpresa($id){
        try{
            $conexion = new Conexion();
            $db = $conexion->getConexion();

            $query = "delete from empresa where id = ?";
            $statement = $db->prepare($query);
            $statement->execute([$id]);

        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }

    
    public function addEmpresa()
    {
        try {
            $conexion = new Conexion();
            $db = $conexion->getConexion();

            $query = "INSERT INTO empresa VALUES (null , :name,:status)";

            $statement = $db->prepare($query);
            $statement->bindParam(":name", $this->nombre);
            $statement->bindParam(":status", $this->estatus);
            $statement->execute();


            $lastId = $db->lastInsertId();
            $options = array("0"=>true,"1"=>"".$lastId);

            return $options;
        } catch (PDOException $e) {
            //EL VALOR DE AUTOINCREMENTO DE LA TABLA empresa
            //SE INCREMENTA CUANDO HAY UN ERROR AL INSERTAR 
            //ESO NO TIENE QUE PASAR 

            //LOGICA PARA RESTARLE UNO AL VALOR
            //DE AUTOINCREMENTO

            //OBTENGO EL VALOR MAXIMO DEL ID
            $query = "select max(id) as maxid from empresa";
            $stm = $db->query($query);
            //CONVIERTO EL RESULT A ARRAY DEL VALOR ID 
            $result = $stm->fetchall(PDO::FETCH_ASSOC);

            //ACTUALIZO EL VALOR DE AUTOINCREMENTO POR EL VALOR MAXIMO OBTENIDO
            $query = "ALTER TABLE empresa AUTO_INCREMENT = " . $result[0]['maxid'];
            $stm = $db->query($query);

            //RETORNO UN ARRAY CON DATOS DEL ERROR(pdoexception)
            return $e->errorInfo;
        }
    }
}
