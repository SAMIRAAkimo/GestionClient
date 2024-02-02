<?php
require_once '../../config/db_config.php';

define("success", "success");
define("erreur", "Enregistrement echoue");


function district()
{
    global $mysqli;

    $requette = " SELECT `id_district`, `district`, `status` FROM `district` WHERE 1";

    $resultat = $mysqli->query($requette);
    $result_obt = array();

    if ($resultat->num_rows > 0) {
        while ($row = $resultat->fetch_assoc()) {
            $result_obt[] = $row;
        }
    }
    return $result_obt;
}

function commune()
{
    global $mysqli;
    $requette = "SELECT `id_commune`, `id_district`, `commune`, `status`, `logo` FROM `commune` WHERE 1";

    $rst = $mysqli->query($requette);

    $result_obt = array();

    if ($rst->num_rows > 0) {
        while ($row = $rst->fetch_assoc()) {

            $result_obt[] = $row;
        }
    }
    return $result_obt;
}

function upload_no_file($requette)
{
    global $mysqli;
    $mysqli->query($requette);
    if ($mysqli->affected_rows > 0) {
        echo success;
    } else {
        echo erreur;
    }
}

function  upload_one_file($image_location, $importation)
{
    global $mysqli;
    if (file_exists($importation)) {
        unlink($importation);
    }
    if ($mysqli->affected_rows > 0) {
        if (move_uploaded_file($image_location, $importation)) {
            echo success;
        } else {
            echo "Commune ajouter mais aucune image";
        }
    } else {
        if (move_uploaded_file($image_location, $importation)) {
            echo success;
        } else {
            echo erreur;
        }
    }
}


if (isset($_POST['AFFICHAGE_DISTRICT'])) {

    $result_obt = array();

    $result_obt[] = district();
    $result_obt[] = commune();

    echo json_encode($result_obt);
}

if (isset($_POST['INSERTION_DISTRICT'])) {

    $libelle_district = addslashes($_POST['libelle_district']);
    $libelle_district = trim($libelle_district);
    $status = 1;
    $requette = "SELECT * FROM  `district` WHERE `district`='$libelle_district'";

    $rst = $mysqli->query($requette);

    if ($rst->num_rows > 0) {
        while ($row = $rst->fetch_assoc()) {
            echo "District exise dejà";
        }
    } else {
        if (isset($_POST['id_district'])) {
            $id_district = $_POST['id_district'];
          
        }
        if (!empty($id_district)) {
           
            $requette = "UPDATE `district` SET `district`='$libelle_district' , `status`='$status' WHERE id_district='$id_district'";

        } else {
            $requette = "INSERT INTO `district`(`district`) VALUES ('$libelle_district')";
            
        }

        upload_no_file($requette);
    }
   

}

if (isset($_POST['INSERTION_COMMUNE'])) {

    if (isset(($_FILES['image']['size']))) {

        $id_commune = addslashes($_POST['id_commune']);
        $image_name = $_FILES['image']['name'];
        $image_location = $_FILES['image']['tmp_name'];
        $file_extension = pathinfo($image_name, PATHINFO_EXTENSION);
        $file_extension = strtolower($file_extension);
       

        $image = $id_commune . "." . $file_extension;
        $importation = "../../assets/img/commune/" . $image;

        $requette = "UPDATE `commune` SET `logo`='$image' WHERE `id_commune`='$id_commune'";

        $mysqli->query($requette);

        upload_one_file($image_location, $importation);
    } else {
        $libelle_commune = addslashes($_POST['libelle_commune']);
        $libelle_commune = trim($libelle_commune);
        $image = "";

        $requette = '';
        $status = 1;
        if (isset($_POST['satus'])) {
            $status = $_POST['satus'];
        }
        if (isset($_POST['id_commune'])) {

            $id_commune = addslashes($_POST['id_commune']);
            $requette = "UPDATE `commune` SET `commune`='$libelle_commune',`status`='$status' WHERE `id_commune`='$id_commune'";
        } else {

            $id_district = $_POST['id_district'];

            $check = "SELECT * FROM `commune` WHERE `id_district`='$id_district' AND `commune`='$libelle_commune'";

            $rst = $mysqli->query($check);
            $result_obt = array();
            if ($rst->num_rows > 0) {
                echo "Ce commune existe deja dans ce district";
                exit();
            } else {
                $requette = "INSERT INTO `commune`(`id_district`,`commune`) VALUES ('$id_district','$libelle_commune')";
            }
        }

        upload_no_file($requette);
    }
}

if (isset($_POST['SELECT_DISTRICT'])) {
    $id_district = $_POST['id_district'];
    $requette = "SELECT `id_district`, `district`, `status` FROM `district` WHERE `id_district`= '$id_district' ";

    $rst = $mysqli->query($requette);
    $result_obt = array();

    if ($rst->num_rows > 0) {
        while ($row = $rst->fetch_assoc()) {
            $result_obt[] = $row;

            $libelle_district = $row["district"];
        }
        echo $libelle_district;
    }
}

if (isset($_POST['SELECT_COMMUNE'])) {
    $id_commune = $_POST['id_commune'];
    $requette = "SELECT `id_commune`, `id_district`, `commune`, `status` FROM `commune` WHERE `id_commune`= '$id_commune' ";

    $rst = $mysqli->query($requette);
    $result_obt = array();

    if ($rst->num_rows > 0) {
        while ($row = $rst->fetch_assoc()) {
            $result_obt[] = $row;

            $libelle_commune = $row["commune"];
        }
        echo $libelle_commune;
    }
}

if (isset($_POST['SUPPRESSION_DISTRICT'])) {

    $id_district = $_POST['id_district'];

    $requette = "SELECT * FROM `commune` WHERE `id_district`='$id_district'";

    $mysqli->query($requette);
    if ($mysqli->affected_rows > 0) {

        echo "Ce district ne peut pas etre supprimer, car il contient des commune";
    } else {

        $requette = "DELETE FROM `district` WHERE `id_district`='$id_district'";
        $mysqli->query($requette);
        if ($mysqli->affected_rows > 0) {
            echo success;
        }
    }
}

if (isset($_POST['SUPPRESSION_COMMUNE'])) {

    $id_commune = $_POST['id_commune'];

    $requette = "DELETE FROM `commune` WHERE `id_commune`='$id_commune'";

    $mysqli->query($requette);
    if ($mysqli->affected_rows > 0) {
        echo success;
    } else {
        echo "erreur de suppression";
    }
}

if (isset($_POST['SUPPR_LOGO_COMMUNE'])) {

    $id_commune = $_POST['id_commune'];
    $image = $_POST['image'];

    $importation = "../../assets/img/commune/" . $image;
    $requette = "UPDATE `commune` SET `logo`='' WHERE `id_commune`='$id_commune'";
    $mysqli->query($requette);
    if ($mysqli->affected_rows > 0) {


        if (file_exists($importation)) {

            if (unlink($importation)) {
                echo "success";
            } else {
                echo "echec de suppression";
            }
        } else {
            echo "image n\'existe pas ";
        }
    } else {
        echo erreur;
    }
}
