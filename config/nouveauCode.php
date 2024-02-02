<?php

include './db_config.php';

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class nouveauCode {

    public function getCode($table, $column, $entete, $longNum) {
        //verifier  si il exite espace au milieu
          
        $entete = cleanCharacte($entete);

//        echo '1';
        //CRÉER UNE CONEXION
//        $mysqli1 = new mysqli("localhost", "root", "magic", "DEGSP");
        
        $sql_query = "SELECT  MAX($column) max_id FROM $table WHERE $column LIKE '" . $entete . "%' AND length($column) = (length('$entete') + $longNum) ";
        
//        echo $sql_query;
        global $mysqli;
        
        $result = $mysqli->query($sql_query);

//        echo '2';

        $new_num_ID = '';

        if ($result->num_rows > 0) {

            $last_max_id = '';

            //recuperer last max id
            $numRef = '';
            foreach ($result as $row) {
                $last_max_id = $row['max_id'];
                $numRef = $row['max_id'];
            }
 
            //recuprer le num max
            $last_max_id = str_replace($entete, '', $last_max_id);

            $last_max_id = $last_max_id + 1; 

            $strlen = strlen('' . $last_max_id);
 
            $rang = $longNum - $strlen;
 
            $id_formater = $last_max_id;

            for ($i = 0; $i < $rang; $i++) {
                $id_formater = '0' . $id_formater;
            }

            $new_num_ID = $entete . $id_formater;
 
        } else {

            $new_num_ID = $entete .'0001';
        }

        return  $new_num_ID;
    }

}
 
