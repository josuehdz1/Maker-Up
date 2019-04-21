<?php
    
    /**
     * Definimos una constante la cual contiene un strign que permitira
     * obtener el id de una columna en cuanto de inserta
     *      USE IN: function add(:table, :colums, GET_AUTO_ID)
     * @final 
     * @global string GET_AUTO_ID
     */
    define("GET_AUTO_ID", "RETURN_ID");

    /**
     * Contine un valor strign, el cual es la direccion en la que se 
     * encuentra un archivo para asi poder llegar a el este donde este.
     * @final
     * @global string CURRENT_ADDRESS_URL
     */
    define("CURRENT_ADDRESS_URL", dirname(__FILE__));
    

    // include the class in this file for we can used in future 
    require_once CURRENT_ADDRESS_URL.'\build\Insert.Function\fn.insert.php';
    require_once CURRENT_ADDRESS_URL.'\gen\Provider.database.php';

    /**
     * @package DB
     * @author Josue Hernandez <josueprogramer@gmail.com>
     * @version 1.0 
     * @license MIT
     * @final
     */
    class DB{

        /**
        * @var object      $GeneralDB
        * @access public
        */
        /**
        * Esta variable almacena la conexion de la base de datos para uso futuro.
        */
        public $db;

        /**
        * @param array     $DataConfig
        */
        function __construct($DataConfig = []){
        
            /**
            *  usa esta clase para instanciar los metodos de conexion a una base de
            *  datos con el proveedor de preferencia.
            */
            $ConnectService = new Connector();

            //usamos esta condicion para seleccionar el proveedor de base de datos
            switch ($DataConfig[0]) {
            
                // usamos el nombre den provedor como variable en la seleccion.
                case 'mysql':

                    // tomamos la variable en la que se instacio la clase proveedor
                    /**
                    * Los indices del array ($DataConfig) fueron nombrados de la siguiente forma para su 
                    * envio y su posterior uso:
                    *          indice: 1 => Host
                    *                  2 => User
                    *                  3 => Pass
                    *                  4 => Table name
                    */
                    $this->db = $ConnectService->UseMySQL([$DataConfig[1], $DataConfig[2], $DataConfig[3], $DataConfig[4]]);
                    break;

                    // Caso por defecto, se informa la no existencia del provedor escrito.       
                default:
                    print("Not exist this service (Error in the database manager provider)");
                    break;
            }        
        }
    
        /**
        * @param string    $Table
        * @param array     $DataColumn
        * @return object
        */
        public function add($Table, $DataColumn = [], $GetAutoId = false){
        
            // Se creo una instacia de la clase para uso de sus metodos.
            $insert = new Insert();

            /**
            * Retornamos 
            */
            if(@count($DataColumn[0]) > 1){
                return $insert->TwoAndMoreInsert([$DataColumn, $Table, $this->db, $GetAutoId]);
            }
            else{
                return $insert->OneNotMoreInsert([$DataColumn, $Table, $this->db, $GetAutoId]);
            }
        }
    }