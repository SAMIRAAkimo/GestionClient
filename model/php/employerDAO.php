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


if (isset($_POST['SELECT_ALL_EMPLOYER'])) {
    $id = 1;

    if (isset($_POST['idClient'])) $id =  'client.`idClient`=' . $_POST['idClient'];

    $requette = "SELECT reservation.`idClient`, reservation.`num_chambre`, reservation.`forfait`, 
        reservation.`dateArrivee`, reservation.`dateDepart`,
         `num_chambre`,reservation.`societe`, reservation.`tarifNuite`, reservation.`refBar`,
          reservation.`montantBar`, reservation.`refRestaurant`, reservation.`montantRestaurant`, 
          reservation.`refFrigo`, reservation.`montantFrigo`, reservation.`refLingerie`, 
          reservation.`montantLingerie`, reservation.`refLocation`, reservation.`montantLocation`, 
          reservation.`refNuite`, reservation.`montantNuite`, reservation.`totalJour`,
          reservation.`totalFacture`, client.`nomClient`, client.`prenom`, client.`dateNais`,
           client.`lieuNais`, client.`pere`, client.`mere`, client.`type`, client.`profession`, 
           client.`nationalite`, client.`domicileExacte`, client.`telephone`, client.`photocopieCIN`,
            client.`photocopiePasseport`, client.`statut`
            FROM `client`
                           LEFT JOIN reservation ON reservation.`idClient`= client.`idClient` WHERE $id";

    $resultat = '';

    //echo $requette;
    $resultat = $mysqli->query($requette);

    $resul_obt = array();

    if ($resultat->num_rows > 0) {
        while ($row = $resultat->fetch_assoc()) {
            $resul_obt[] = $row;
        }
    }
    echo json_encode($resul_obt);
}

if (isset($_POST['SELECT_ALL_EMPLOYER_FILTRE'])) {

    $requette = "SELECT reservation.`num_chambre`, reservation.`dateArrivee`, reservation.`dateDepart`,
                reservation.`totalJour` FROM `client`
                LEFT JOIN reservation ON reservation.`idClient`= client.`idClient` WHERE 1";

    $resultat = '';

    $resultat = $mysqli->query($requette);

    $resul_obt = array();

    if ($resultat->num_rows > 0) {
        while ($row_client = $resultat->fetch_assoc()) {
          
            $date_client = array();
            for($c=0 ; $row_client['totalJour'] >= $c;$c++ ){
                $date_client[]=(date("Y-m-d",strtotime($row_client['dateArrivee'] .' + '.$c.' days')));
            }

            $resul_obt[]= [
                        
                'num_chambre'=> $row_client['num_chambre'],
                'dateArrivee'=> $row_client['dateArrivee'],
                'dateDepart'=> $row_client['dateDepart'],
                'jour'=> implode(',',$date_client),

            ];
        }
    }
    echo json_encode($resul_obt);
}

if (isset($_POST['detail'])) {
    $id = $_POST['id'];
    $requette = "SELECT * FROM `client`LEFT JOIN reservation ON reservation.idClient= client.idClient WHERE 1";
    $resultat = $mysqli->query($requette);

    if ($resultat->num_rows > 0) {
        while ($row = $resultat->fetch_assoc()) {
            $resul_obt[] = $row;
        }
    }
    echo json_encode($resul_obt);
}

if (isset($_POST['INSERTION_EMPLOYER'])) {

    //client
    $idClient = isset($_POST['idClient'])  ? $_POST['idClient'] : '';
    $nom = addslashes($_POST['nom']);
    $prenom = addslashes($_POST['prenom']);
    $datenais = trim(addslashes($_POST['datenais']));
    $lieunais = addslashes($_POST['lieunais']);
    $type = addslashes($_POST['type']);
    $pere = addslashes($_POST['pere']);
    $mere = addslashes($_POST['mere']);
    $telephone = addslashes($_POST['telephone']);
    $nationalite = addslashes($_POST['nationalite']);
    $domicile = addslashes($_POST['domicile']);
    $profession = addslashes($_POST['profession']);

    // reservation

    $numchambre = array();

    $numchambre = implode(',', $_POST['numchambre']);
    $societe = trim(addslashes($_POST['societe']));
    $forfait = trim(addslashes($_POST['forfait']));
    $arrive = trim(addslashes($_POST['arrive']));
    $depart = trim(addslashes($_POST['depart']));
    $tarifnuite = ($_POST['tarifnuite']);
    $refbar = trim(addslashes($_POST['refbar']));
    $refrest = trim(addslashes($_POST['refrest']));
    $reffrigo = trim(addslashes($_POST['reffrigo']));
    $reflinge = trim(addslashes($_POST['reflinge']));
    $refloca = trim(addslashes($_POST['refloca']));
    $refnuite = trim(addslashes($_POST['refnuite']));
    $totaljour = trim(addslashes($_POST['totaljour']));
    $montantbar = trim(addslashes($_POST['montantbar']));
    $montantrest = trim(addslashes($_POST['montantrest']));
    $montantfrigo = trim(addslashes($_POST['montantfrigo']));
    $montantlinge = trim(addslashes($_POST['montantlinge']));
    $montantloca = trim(addslashes($_POST['montantloca']));
    $montantnuite = trim(addslashes($_POST['montantnuite']));
    $totalfac = trim(addslashes($_POST['totalfac']));


    $cin = $_FILES["cin"]["name"];
    $passeport = $_FILES['passeport']["name"];
    $location_image = $_FILES["cin"]["tmp_name"];
    $location_image_pass = $_FILES["passeport"]["tmp_name"];

    //$src = "../assets/image/Photos/".$passeport;

    $file_extention = pathinfo($cin, PATHINFO_EXTENSION);
    $file_extention = strtolower($file_extention);
    $img_move = "";
    $file_extention_pass = pathinfo($passeport, PATHINFO_EXTENSION);
    $file_extention_pass = strtolower($file_extention_pass);


    $sql = "show table status like 'client'";
    $query = $mysqli->query($sql);
    $max_id = "";
    $img_move = "";
    $pass_id = "";
    $img_move_pass = "";
    $img_modif = '';


    if ($query->num_rows > 0) {
        $row = $query->fetch_assoc();
        $max_id = $row['Auto_increment'];
        $pass_id = $row['Auto_increment'];
    }
    if ($_FILES["cin"]["size"] > 0) {
        $img_move = $max_id . "." . $file_extention;
        if (isset($_POST['idClient'])) {
            $img_move = $idClient . "." . $file_extention;
        }

        $importation = "../../assets/image/Photos/" . $img_move;


        move_uploaded_file($location_image, $importation);
    }
    if ($_FILES["passeport"]["size"] > 0) {
        $img_move_pass = "pass" . $pass_id . "." . $file_extention_pass;
        if (isset($_POST['idClient'])) {
            $img_move_pass = "pass" . $idClient . "." . $file_extention_pass;
        }

        $importation_pass = "../../assets/image/Photos/" . $img_move_pass;

        move_uploaded_file($location_image_pass, $importation_pass);
    }
    $cin_rq = ($_FILES["cin"]["size"] > 0) ? ",`photocopieCIN`='$img_move'"  : '';
    $pass_rq = ($_FILES["passeport"]["size"] > 0) ? ",`photocopiePasseport`='$img_move_pass'" : '';
    $img_modif .= $cin_rq;
    $img_modif .= $pass_rq;


    $update_client = "UPDATE `client` SET `nomClient`='$nom',`prenom`='$prenom',
        `dateNais`='$datenais',`lieuNais`='$lieunais',`pere`='$pere ',`mere`='$mere',`type`='$type',`profession`='$profession',
        `nationalite`='$nationalite',`domicileExacte`='$domicile',`telephone`='$telephone' '$img_modif'
         WHERE `idClient`='$idClient '";


    $update_reservation = "UPDATE `reservation` SET `idClient`='$idClient ',`num_chambre`='$numchambre',`forfait`='$forfait',
        `societe`='$societe',`dateArrivee`='$arrive',`dateDepart`='$depart',`tarifNuite`='$tarifnuite',`refBar`=' $refbar ',
        `montantBar`='$montantbar ',`refRestaurant`='$refrest',`montantRestaurant`=' $montantrest',
        `refFrigo`='$reffrigo',`montantFrigo`='$montantfrigo',`refLingerie`='$reflinge',`montantLingerie`=' $montantlinge',
        `refLocation`=' $refloca ',`montantLocation`='$montantloca',`refNuite`='$refnuite ',
        `montantNuite`='$montantnuite',`totalJour`=' $totaljour',`totalFacture`='$totalfac' WHERE `idClient`='$idClient '";


    $insert_client =
        "INSERT INTO `client`(`nomClient`, `prenom`, `dateNais`, `lieuNais`, `pere`, 
        `mere`, `type`, `profession`, `nationalite`, `domicileExacte`, `telephone`,`photocopieCIN`,
         `photocopiePasseport`) 
        VALUES ('$nom','$prenom','$datenais','$lieunais','$pere','$mere','$type','$profession','$nationalite',
        '$domicile','$telephone','$img_move','$img_move_pass')";


    $insert_reservation = "INSERT INTO `reservation`(`idClient`, `num_chambre`, `forfait`, `societe`,
         `dateArrivee`, `dateDepart`, `tarifNuite`, `refBar`, `montantBar`, `refRestaurant`, 
         `montantRestaurant`, `refFrigo`, `montantFrigo`, `refLingerie`, `montantLingerie`,
          `refLocation`, `montantLocation`, `refNuite`, `montantNuite`, `totalJour`, `totalFacture`)
        VALUES ('$max_id','$numchambre','$forfait','$societe','$arrive','$depart','$tarifnuite',
        '$refbar','$montantbar','$refrest','$montantrest','$reffrigo','$montantfrigo','$reflinge',
        '$montantlinge','$refloca','$montantloca','$refnuite','$montantnuite','$totaljour','$totalfac')";

    // echo "$insert_reservation";
    // echo $insert_client;

    if ((isset($_POST['idClient']))) {

        $idClient = $_POST['idClient'];
        $mysqli->query($update_client);
        if ($mysqli->affected_rows > 0) {

            $mysqli->query($update_reservation);
            if ($mysqli->affected_rows > 0) {
                echo "success";
            } else {
                echo "erreur";
            }
        } else {
            echo "erreur";
        }
    } else {

        $mysqli->query($insert_client);
        if ($mysqli->affected_rows > 0) {

            $mysqli->query($insert_reservation);
            if ($mysqli->affected_rows > 0) {
                echo "success";
            } else {
                echo "erreur";
            }
        }
    }
}

if (isset($_POST['SUPPR_EMPLOYER'])) {
    $idClient = $_POST['idClient'];

    $requette = "DELETE FROM `client` WHERE `idClient`='$idClient'";
    $mysqli->query($requette);

    if ($mysqli->affected_rows > 0) {

        $requette = "DELETE FROM `reservation` WHERE `idClient`='$idClient'";
        $mysqli->query($requette);

        if ($mysqli->affected_rows > 0) {
            echo success;
        } else {
            echo 'Client supprimé';
        }
    } else {
        echo "Client n\'existe pas";
    }
}

// chambre //

if (isset($_POST['SELECT_ALL_CHAMBRE'])) {


    if (isset($_POST['id_chambre'])) {
        $id_chambre = $_POST['id_chambre'];
        $requette = "SELECT `id_chambre`, `num_chambre`, `description`, `type`, `tarifNuite` FROM `chambre` WHERE `id_chambre`='$id_chambre'";
    } else {

        $requette = "SELECT `id_chambre`, `num_chambre`, `description`, `type`, `tarifNuite` FROM `chambre` ORDER BY `chambre`.`num_chambre` ASC";
    }

    select_all($requette);
}
if (isset($_POST['INSERTION_CHAMBRE'])) {


    $id_chambre = $_POST['id_chambre'];
    $num_chambre = addslashes($_POST['num_chambre']);
    $description = addslashes($_POST['description']);
    $type = addslashes($_POST['type']);
    $tarif = addslashes($_POST['tarif']);
    // $requette = "SELECT `id_chambre`, `num_chambre` FROM `chambre` WHERE  `num_chambre`='$num_chambre'";

    if (!empty(is_numeric($id_chambre))) {
        $id_chambre = $_POST['id_chambre'];
        $requette_update = "UPDATE `chambre` SET `num_chambre`='$num_chambre',`description`='$description',`type`='$type',`tarifNuite`='$tarif' WHERE `id_chambre`='$id_chambre'";
    } else {
        $requette_insert = "INSERT INTO `chambre`(`num_chambre`,`description`,`type`,`tarifNuite`) VALUES ('$num_chambre','$description','$type','$tarif')";
    }

    if (!empty(is_numeric($id_chambre))) {

        //$id_chambre = $_POST['id_chambre'];
        $mysqli->query($requette_update);
        if ($mysqli->affected_rows > 0) {
            echo "success";
        } else {
            echo "erreur";
        }
    } else {

        $mysqli->query($requette_insert);
        if ($mysqli->affected_rows > 0) {
            echo "success";
        } else {
            echo "erreur";
        }
    }

    //upload_no_img($requette);
}
if (isset($_POST['DELETE_CHAMBRE'])) {

    $id_chambre = $_POST['id_chambre'];
    $requette = "DELETE FROM `chambre` WHERE `id_chambre`='$id_chambre'";
    $mysqli->query($requette);
    if ($mysqli->affected_rows > 0) {
        echo success;
    } else {
        echo "Erreur de supression";
    }
}

if (isset($_POST['STATUT_CLIENT'])) {
    $id = $_POST['id'];
    $statut = $_POST['statut'];

    $statut_client = "UPDATE `client` SET `statut`='$statut' WHERE `idClient`=$id";
    $mysqli->query($statut_client);
    if ($mysqli->affected_rows > 0) {
        echo "success";
    } else {
        //echo "erreur";
    }
}

if (isset($_POST['FILTRE_CLIENT'])) {
    $filtre = $_POST["filtre"];

    if ($filtre == 1) {
        $requette = "SELECT reservation.`idClient`, reservation.`num_chambre`, reservation.`dateArrivee`, reservation.`dateDepart`,
         `num_chambre`,reservation.`societe`, reservation.`tarifNuite`, reservation.`refBar`,
          reservation.`montantBar`, reservation.`refRestaurant`, reservation.`montantRestaurant`, 
          reservation.`refFrigo`, reservation.`montantFrigo`, reservation.`refLingerie`, 
          reservation.`montantLingerie`, reservation.`refLocation`, reservation.`montantLocation`, 
          reservation.`refNuite`, reservation.`montantNuite`, reservation.`totalJour`,
          reservation.`totalFacture`, client.`nomClient`, client.`prenom`, client.`dateNais`,
           client.`lieuNais`, client.`pere`, client.`mere`, client.`profession`, client.`nationalite`, 
           client.`domicileExacte`, client.`telephone`, client.`photocopieCIN`, client.`photocopiePasseport`, client.`statut`
            FROM `client`
                           LEFT JOIN reservation ON reservation.`idClient`= client.`idClient` WHERE client.`statut`=1";
        $resultat = '';

        // echo $requette;
        $resultat = $mysqli->query($requette);

        $resul_obt = array();

        if ($resultat->num_rows > 0) {
            while ($row = $resultat->fetch_assoc()) {
                $resul_obt[] = $row;
            }
        }
        echo json_encode($resul_obt);
    }
    if ($filtre == 2) {
        $requette = "SELECT reservation.`idClient`, reservation.`num_chambre`, reservation.`dateArrivee`, reservation.`dateDepart`,
         `num_chambre`,reservation.`societe`, reservation.`tarifNuite`, reservation.`refBar`,
          reservation.`montantBar`, reservation.`refRestaurant`, reservation.`montantRestaurant`, 
          reservation.`refFrigo`, reservation.`montantFrigo`, reservation.`refLingerie`, 
          reservation.`montantLingerie`, reservation.`refLocation`, reservation.`montantLocation`, 
          reservation.`refNuite`, reservation.`montantNuite`, reservation.`totalJour`,
          reservation.`totalFacture`, client.`nomClient`, client.`prenom`, client.`dateNais`,
           client.`lieuNais`, client.`pere`, client.`mere`, client.`profession`, client.`nationalite`, 
           client.`domicileExacte`, client.`telephone`, client.`photocopieCIN`, client.`photocopiePasseport`, client.`statut`
            FROM `client`
                           LEFT JOIN reservation ON reservation.`idClient`= client.`idClient` WHERE client.`statut`=0";

        $resultat = '';

        // echo $requette;
        $resultat = $mysqli->query($requette);

        $resul_obt = array();

        if ($resultat->num_rows > 0) {
            while ($row = $resultat->fetch_assoc()) {
                $resul_obt[] = $row;
            }
        }
        echo json_encode($resul_obt);
    }
    if ($filtre == 3) {

        $id = 1;

        if (isset($_POST['idClient'])) $id =  'client.`idClient`=' . $_POST['idClient'];

        $requette = "SELECT reservation.`idClient`, reservation.`num_chambre`, reservation.`dateArrivee`, reservation.`dateDepart`,
            `num_chambre`,reservation.`societe`, reservation.`tarifNuite`, reservation.`refBar`,
            reservation.`montantBar`, reservation.`refRestaurant`, reservation.`montantRestaurant`, 
            reservation.`refFrigo`, reservation.`montantFrigo`, reservation.`refLingerie`, 
            reservation.`montantLingerie`, reservation.`refLocation`, reservation.`montantLocation`, 
            reservation.`refNuite`, reservation.`montantNuite`, reservation.`totalJour`,
            reservation.`totalFacture`, client.`nomClient`, client.`prenom`, client.`dateNais`,
            client.`lieuNais`, client.`pere`, client.`mere`, client.`profession`, client.`nationalite`, 
            client.`domicileExacte`, client.`telephone`, client.`photocopieCIN`, client.`photocopiePasseport`, client.`statut`
            FROM `client`
                           LEFT JOIN reservation ON reservation.`idClient`= client.`idClient` WHERE $id";
        $resultat = '';

        // echo $requette;
        $resultat = $mysqli->query($requette);

        $resul_obt = array();

        if ($resultat->num_rows > 0) {
            while ($row = $resultat->fetch_assoc()) {
                $resul_obt[] = $row;
            }
        }
        echo json_encode($resul_obt);
    }
}



// fonction //
