<?php
class SPDO
{
    private $PDOInstance = null;
    private static $instance = null;
    // const DEFAULT_SQL_USER = 'root';
    // const DEFAULT_SQL_HOST = 'localhost';
    // const DEFAULT_SQL_PASS = '';
    // const DEFAULT_SQL_DTB = 'jeux';
    const DEFAULT_SQL_USER = 'u362629279_user';
    const DEFAULT_SQL_HOST = 'mysql.hostinger.fr';
    const DEFAULT_SQL_PASS = 'b0b0president';
    const DEFAULT_SQL_DTB = 'u362629279_bdd';
   
    private function __construct() 
    {   
           try     
           {
                $this->PDOInstance = new PDO('mysql:host='.self::DEFAULT_SQL_HOST.';dbname='.self::DEFAULT_SQL_DTB,self::DEFAULT_SQL_USER,self::DEFAULT_SQL_PASS); 
           }   
           catch (PDOException $e)   
           {         
                echo 'Erreur : ' .$e->getMessage() . '<br />';  
                exit;
           }     
    }
   
    public static function getInstance()
    {
        if(is_null(self::$instance))   
        {
            self::$instance = new SPDO();  
        }
        return self::$instance;
    }
   
    public function query($query, $isObejct = false, $data = array())
    {
         $req = $this->PDOInstance->prepare($query);
         $req->execute();
         if($isObejct == true)
         {
             return $req->fetchAll(PDO::FETCH_OBJ);
         }
         else
         {
             return $req->fetchAll();
         }
    }
 
    public function __call($method, $args) 
    {     
        return $this->PDOInstance->$method($args[0]);
    }
}
?>