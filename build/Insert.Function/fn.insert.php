<?php      
    /**
     * @package DB
     * @author Josue Hernandez <josueprogramer@gmail.com>
     * @version 1.0
     * @final
     * @license MIT
     */
    class Insert{        
        /**
         * Nombramos los indices en la variable ($Data), para un uso mas
         * concreto e entendible.
         *      indice:     0 => Content
         *                  1 => Table
         *                  2 => Connection
         * @param array     $Data         
         * @return bool
         * @final
         */
        public function TwoAndMoreInsert($Data = []){

            /**
             * Usamos esta valiable array para contener los id de cada
             * columna, ya que esta funcion produce multiples inserts.
             * @var array $idReturn
             */
            $idReturn = [];

            // usamos el indice 0 => Content para insertar lo pedido por el usuario
            /**
             * | Usamos el contenido mandado por el usuario, lo retonamos por medio de un foreach
             * | Llamaremos a la clave de cada lista como: Key: $Subarray, y a su valor como: Value: $Content
             * | El contenido que usaremos proviene del valor de cada clave de este objeto.             
             */
            foreach ($Data[0] as $Subarray => $Content) {
                
                /**
                 * | Con el metodo prepare(), la sentencia SQL puede contener cero o más marcadores de parámetros 
                 * | con nombre (:name) o signos de interrogación (?) por los cuales los valores reales serán sustituidos cuando 
                 * | la sentencia sea ejecutada. 
                 */
                $stm = $Data[2]->prepare("INSERT INTO $Data[1] (".filter_var(implode(", ", array_flip($Content)), FILTER_SANITIZE_STRING).") VALUES ("."'".implode("',' ",$Content)."'".")");
                
                // Se ejecuta el query en el servidor
                $stm->execute();
                // Si la constante contiene este valor, entonces obtendremos el id de la columna insertada
                if ($Data[3] == "RETURN_ID") {
                
                    // Se añade en un array el id de la columna insertada 
                    array_push($idReturn, $Data[2]->lastInsertId());
                }            
            }

            /**
             * Si se tiene mas de 0 registros en este array
             * se returnara al usurio.
             */
            if(count($idReturn) > 0){
                // Returnamos el array
                return $idReturn;
            }
            else{
                // De lo contrario devolvemos el valor bool obtenido despues de la consulta
                return $stm;    
            }            
        }

        /**
         * Nombramos los indices en la variable ($Data), para un uso mas
         * concreto e entendible.
         *      indice:     0 => Content
         *                  1 => Table
         *                  2 => Connection
         * @param array     $Data         
         * @return bool
         */
        public function OneNotMoreInsert($Data = []){            
            /**
             * | Con el metodo prepare(), la sentencia SQL puede contener cero o más marcadores de parámetros 
             * | con nombre (:name) o signos de interrogación (?) por los cuales los valores reales serán sustituidos cuando 
             * | la sentencia sea ejecutada. 
            */
            $stm = $Data[2]->prepare("INSERT INTO $Data[1] (".filter_var(implode(", ", array_flip($Data[0])), FILTER_SANITIZE_STRING).") VALUES ("."'".implode("',' ",$Data[0])."'".")");
                
            // Se ejecuta el query en el servidor
            $stm->execute();

            // Si la constante contiene este valor, entonces obtendremos el id de la columna insertada
            if ($Data[3] == "RETURN_ID") {
                
                // Se retorna el id de la columna insertada 
                return $Data[2]->lastInsertId();
            }
            else{
                
                // De lo contrario solo retornamos el valo bool de la consulta
                return $stm;
            }
        }
    }