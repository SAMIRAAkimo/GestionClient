<?php
require_once '../../config/db_config.php';
displayError();

define("success", "success");
define("erreur", "Enregistrement echoue");


function select_all($requette)
{
    global $mysqli;
    $resultat = '';
    $resultat = $mysqli->query($requette);

    $resul_obt = array();

    if ($resultat->num_rows > 0) {
        while ($row = $resultat->fetch_assoc()) {
            $resul_obt[] = $row;
        }
    }
    echo json_encode($resul_obt);
}






// user //

if (isset($_POST['USER_AFFICHAGE'])){


    if (isset($_POST['id'])) {
        $id = $_POST['id'];
        $requette = "SELECT `id`, `username`, `motdepasse`, `statut` FROM `personnel` WHERE `id`='$id'";
    } else {

       $requette = "SELECT `id`, `username`, `motdepasse`, `statut` FROM `personnel` ORDER BY `personnel`.`statut` ASC";
    }

    select_all($requette);
}
if (isset($_POST['INSERTION_USER'])) {
    $requette_insert="";
    $requette_update="";
    $id="";
    //$id = $_POST['id'];
    $username = addslashes($_POST['username']);
    $motdepasse = addslashes($_POST['mdp']);
    $statut = addslashes($_POST['statut']);
   // $requette = "SELECT `id_chambre`, `num_chambre` FROM `chambre` WHERE  `num_chambre`='$num_chambre'";

    if (isset($_POST['id'])) {
        $id = $_POST['id'];
        $requette_update = "UPDATE `personnel` SET `username`='$username',`motdepasse`='$motdepasse',`statut`='$statut' WHERE `id`='$id'";
        
    } else {
        
        $requette_insert = "INSERT INTO `personnel`(`username`,`motdepasse`,`statut`) VALUES ('$username','$motdepasse','$statut')";
    }
    echo $requette_update; 

    if (empty(is_numeric($id))){
        $mysqli->query($requette_insert);
        if ($mysqli->affected_rows > 0) {
             echo "success";
        }else{
             echo "erreur";
        }
        }else {
            $mysqli->query($requette_update);
            if ($mysqli->affected_rows > 0) {
                echo "success";
           }else{
                echo "erreur";
           }
        } 
         
        //$id_chambre = $_POST['id_chambre'];
        

   }

    //upload_no_img($requette);

if (isset($_POST['USER_DELETTE'])) {

    $id = $_POST['id'];
    $requette = "DELETE FROM `personnel` WHERE `id`='$id'";
    $mysqli->query($requette);
    if ($mysqli->affected_rows > 0) {
        echo success;
    } else {
        echo "Erreur de supression";
    }
    //echo $requette;
}

// if (isset($_POST['USER_MODIF'])) {

//     $id = $_POST['id'];
//     $requette_update = "UPDATE `personnel` SET `username`='$username',`motdepasse`='$motdepasse',`statut`='$statut' WHERE `id`='$id'";
//     $mysqli->query($requette_update );
//         if ($mysqli->affected_rows > 0) {
//             echo "success";
//         } else {
//             echo "erreur";
//         }
    
   
// }




