<?php    
    /**
     * @package DB
     * @author Josue Hernandez <josueprogramer@gmail.com>
     * @version 1.0
     * @final
     * @license MIT
     */
    class Connector{
        /**
         * @param array $ServerConfig
         * @return bool
         */
        public function UseMySQL($HostConfig = []){            
            
            // A connection to the database is created for future calls.
            /**
             * Obtenemos mediante los indices del array argumento, cada configuracion requerida.
             * Index:   0 = Host
             *          1 = User
             *          2 = Pass
             *          3 = Data Base name
             * Si se tiene un error devolvera una leyanda informando al usuario
             * por medio de un die.
             */
            try{
                $db = new PDO("mysql:host=$HostConfig[0];dbname=$HostConfig[3]", $HostConfig[1], $HostConfig[2]);
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
            catch(PDOException $e){
                print("Failed to get DB handle: " . $e->getMessage() . "\n");
            }
            
            // Return the connection access.
            return $db;
        }
    }