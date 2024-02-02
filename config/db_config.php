<?php
 
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

define('DB_USER', "root");

define('DB_PASSWORD', "");

define('DB_DATABASE', "gestion_client");

define('DB_HOST', "localhost");


$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);


/* change character set to utf8 */
if (!$mysqli->set_charset("utf8mb4")) {
//    printf("Error loading character set utf8: %s\n", $mysqli->error);
} else {
    $mysqli->character_set_name();
//    printf("Current character set: %s\n", $mysqli->character_set_name());
}

if (!function_exists('cleanCharacte')) {

    function cleanCharacte($string) {
        if ($string != NULL) {
            $string = str_replace('', '-', $string); // Replaces all spaces with hyphens. 
            $string = preg_replace('/[^A-Za-z0-9\-]/', ' ', $string);
            $string = trim($string);
            return $string; // Removes special chars.
        } else {
            return "";
        }
    }

}

// Convertit une date ou un timestamp en français
if (!function_exists('dateToFrench')) {

    function dateToFrench($date, $format) {
        $english_days = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
        $french_days = array('lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi', 'dimanche');
        $english_months = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
        $french_months = array('janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre');
        return str_replace($english_months, $french_months, str_replace($english_days, $french_days, date($format, strtotime($date))));
    }

}

//round up number Ex : 12.85 --> 12.90
if (!function_exists('round_up')) {

    function round_up($value, $precision) {
        $pow = pow(10, $precision);
        return (ceil($pow * $value) + ceil($pow * $value - ceil($pow * $value))) / $pow;
    }

}
if (!function_exists('displayError')) {

    function displayError() {
        /** Error reporting */
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set('Europe/London');
    }

}
if (!function_exists('getAppreciationNote')) {

    function getAppreciationNote($param) {

        $mention = array('Très-Bien', 'Bien', 'Assez-Bien', 'Passable', 'Médiocre');

        if (is_numeric($param)) {

            if ($param >= 16)
                return $mention[0];
            else if ($param >= 14)
                return $mention[1];
            else if ($param >= 12)
                return $mention[2];
            else if ($param >= 10)
                return $mention[3];
            else
                return $mention[4];
        } else {

            return "";
        }
    }

}

if (!function_exists('make_comparer')) {

function make_comparer() {
    // Normalize criteria up front so that the comparer finds everything tidy
    $criteria = func_get_args();
    foreach ($criteria as $index => $criterion) {
        $criteria[$index] = is_array($criterion)
            ? array_pad($criterion, 3, null)
            : array($criterion, SORT_ASC, null);
    }

    return function($first, $second) use (&$criteria) {
        foreach ($criteria as $criterion) {
            // How will we compare this round?
            list($column, $sortOrder, $projection) = $criterion;
            $sortOrder = $sortOrder === SORT_DESC ? -1 : 1;

            // If a projection was defined project the values now
            if ($projection) {
                $lhs = call_user_func($projection, $first[$column]);
                $rhs = call_user_func($projection, $second[$column]);
            }
            else {
                $lhs = $first[$column];
                $rhs = $second[$column];
            }

            // Do the actual comparison; do not return if equal
            if ($lhs < $rhs) {
                return -1 * $sortOrder;
            }
            else if ($lhs > $rhs) {
                return 1 * $sortOrder;
            }
        }

        return 0; // tiebreakers exhausted, so $first == $second
    };
}

}

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
 
if(!function_exists('ComissionDepotOrange')){
    
    function ComissionDepotOrange($montant) {
        if($montant <= 190){
            return 10;
        }else if($montant >= 200 && $montant <= 1175){
            return 10;
        }else if($montant >= 1176 && $montant <= 5175){
            return 64;
        }else if($montant >= 5176 && $montant <= 10350){
            return 136;
        }else if($montant >= 10351 && $montant <= 25800){
            return 200;
        }else if($montant >= 25801 && $montant <= 52000){
            return 315;
        }else if($montant >= 52001 && $montant <= 102500){
            return 360;
        }else if($montant >= 102501 && $montant <= 505500){
            return 720;
        } else if($montant >= 505501 && $montant <= 1011000){
            return 990;
        }else if($montant >= 1011001 && $montant <= 3027500){
            return 1575;
        } else if($montant >= 3027501 && $montant <= 4033000){
            return 2070;
        }else if ($montant >= 4033001 && $montant <= 5000000) {
            return 2700;
        } else {
            0;
        }
    }
    
}
 
if(!function_exists('ComissionRetraitOrange')){
    
    function ComissionRetraitOrange($montant) {
        if($montant <= 190){
            return 10;
        }else if($montant >= 200 && $montant <= 1175){
            return 58.8;
        }else if($montant >= 1176 && $montant <= 5175){
            return 70;
        }else if($montant >= 5176 && $montant <= 10350){
            return 120;
        }else if($montant >= 10351 && $montant <= 25800){
            return 270;
        }else if($montant >= 25801 && $montant <= 52000){
            return 600;
        }else if($montant >= 52001 && $montant <= 102500){
            return 960;
        }else if($montant >= 102501 && $montant <= 254800){
            return 1700;
        }else if($montant >= 254801 && $montant <= 505500){
            return 2125;
        }else if($montant >= 505501 && $montant <= 1011000){
            return 3000;
        }else if($montant >= 1011001 && $montant <= 2022000){
            return 5000;
        }else if($montant >= 2022001 && $montant <= 3027500){
            return 8000;
        }else if($montant >= 3027501 && $montant <= 4033000){
            return 9000;
        }else if ($montant >= 4033001 && $montant <= 5000000) {
            return 10000;
        } else {
            0;
        }
    }
    
}

if(!function_exists('ComissionRetraitTelma')){
    
    function ComissionRetraitTelma($montant) {
        if($montant <= 190){
            return 10;
        }else if($montant >= 200 && $montant <= 1000){
            return 50;
        }else if($montant >= 1001 && $montant <= 5000){
            return 70;
        }else if($montant >= 5001 && $montant <= 10000){
            return 100;
        }else if($montant >= 10001 && $montant <= 25000){
            return 300;
        }else if($montant >= 25001 && $montant <= 50000){
            return 600;
        }else if($montant >= 50001 && $montant <= 100000){
            return 1200;
        }else if($montant >= 100001 && $montant <= 250000){
            return 2000;
        }else if($montant >= 250001 && $montant <= 500000){
            return 2500;
        }else if($montant >= 500001 && $montant <= 1000000){
            return 3000;
        }else if($montant >= 1000001 && $montant <= 2000000){
            return 3500;
        }else if($montant >= 2000001 && $montant <= 3000000){
            return 4000;
        }else if($montant >= 3000001 && $montant <= 4000000){
            return 4500;
        }else if ($montant >= 4000001 && $montant <= 5000000) {
            return 5000;
        } else {
            0;
        }
    }
    
}

if(!function_exists('ComissionDepotTelma')){
    
    function ComissionDepotTelma($montant) {
        if($montant >= 100 && $montant <= 5000){
            return 25;
        }else if($montant >= 5001 && $montant <= 10000){
            return 50;
        }else if($montant >= 10001 && $montant <= 25000){
            return 100;
        }else if($montant >= 25001 && $montant <= 50000){
            return 200;
        }else if($montant >= 50001 && $montant <= 100000){
            return 400;
        }else if($montant >= 100001 && $montant <= 500000){
            return 750;
        }else if($montant >= 500001 && $montant <= 1000000){
            return 1250;
        }else if($montant >= 1000001 && $montant <= 10000000){
            return 1500;
        } else {
            0;
        }
    }
    
}


?>