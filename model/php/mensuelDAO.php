<?php
require_once '../../config/db_config.php';
displayError();

define("success", "success");
define("erreur", "Enregistrement echoue");

$d_i =$_POST['dimanche'];
$l_i =$_POST['lundi'];

$dimanche = strtotime($d_i ."week -1 day");
$lundi = strtotime($l_i ." week 0 day");

$dimanche_week = strtotime("last sunday midnight",$dimanche);
$lundi_week = strtotime("next monday",$lundi);

$start_dimanche = date("d-m-Y",$dimanche_week);
$end_lundi = date("d-m-Y",$lundi_week);

$date_une_sem= array(
    (date("d-m-Y",strtotime($end_lundi .' + 0 days'))),
    (date("d-m-Y",strtotime($end_lundi .' + 1 days'))),
    (date("d-m-Y",strtotime($end_lundi .' + 2 days'))),
    (date("d-m-Y",strtotime($end_lundi .' + 3 days'))),
    (date("d-m-Y",strtotime($end_lundi .' + 4 days'))),
    (date("d-m-Y",strtotime($end_lundi .' + 5 days'))),
    (date("d-m-Y",strtotime($end_lundi .' + 6 days'))),
);

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

if (isset($_POST['SELECT_CLIENT'])) {
    $requette = "SELECT `nomClient`, `prenom` FROM `client`; ";

    $resultat = $mysqli->query($requette);
    $resul_obt = array();

    if ($resultat->num_rows > 0) {
        while ($row = $resultat->fetch_assoc()) {
            $resul_obt[] = $row;
        }
    }
    echo json_encode($resul_obt);
}

if (isset($_POST['SELECT_ALL_MENSUEL'])) {

    $requetteChambre = "SELECT `id_chambre`, `num_chambre`, `description`, `type`, `tarifNuite` FROM `chambre` ORDER BY `chambre`.`num_chambre` ASC";

    $resultatChambre ='';
   //echo $requette;
   $resultatChambre = $mysqli->query($requetteChambre);

   $resul_obt = array();
   $semaine = array( 0,1,2,3,4,5,6);

   if ($resultatChambre->num_rows > 0) {
       while ($row_chambre = $resultatChambre->fetch_assoc()) {
    
        $chbr = $row_chambre['num_chambre'];

        $requette_client = "SELECT reservation.`idClient`, reservation.`num_chambre`, reservation.`forfait`, reservation.`dateArrivee`, reservation.`dateDepart`,
        `num_chambre`,reservation.`societe`, reservation.`tarifNuite`, reservation.`refBar`,
         reservation.`montantBar`, reservation.`refRestaurant`, reservation.`montantRestaurant`, 
         reservation.`refFrigo`, reservation.`montantFrigo`, reservation.`refLingerie`, 
         reservation.`montantLingerie`, reservation.`refLocation`, reservation.`montantLocation`, 
         reservation.`refNuite`, reservation.`montantNuite`, reservation.`totalJour`,
         reservation.`totalFacture`, client.`nomClient`, client.`prenom`, client.`dateNais`,
         client.`lieuNais`, client.`pere`, client.`mere`, client.`type`, client.`profession`, client.`nationalite`, 
         client.`domicileExacte`, client.`telephone`, client.`photocopieCIN`, client.`photocopiePasseport`, client.`statut`
           FROM `client`
                          LEFT JOIN reservation ON reservation.`idClient`= client.`idClient`
                           WHERE reservation.`num_chambre` LIKE '%$chbr%' ";
            
            $resultat_client = '';
        
            $resultat_client = $mysqli->query($requette_client);
            $i=0;

            // echo $requette_client;
            if ($resultat_client->num_rows > 0) {
                while ($row_client = $resultat_client->fetch_assoc()) {

                    $jours='';
                    $date_client = array();
                    for($c=0 ; $row_client['totalJour'] >= $c;$c++ ){
                        $date_client[]=(date("d-m-Y",strtotime($row_client['dateArrivee'] .' + '.$c.' days')));
                    }

                    for($cp=0 ; 7 > $cp; $cp++){
                        
                        for ($n=0; $n < count($date_client); $n++) { 
                            if($date_une_sem[$cp] == $date_client[$n]){
                                $jours .=$cp;
                            }
                        }
                    }

                    $resul_obt[]= [
                        
                        'id_client'=>$row_client['idClient'],
                        'num_chambre'=> $row_chambre['num_chambre'],
                        'nom_client'=> $row_client['nomClient'] .' '.$row_client['prenom'] ,
                        'total_facture'=> $row_client['totalFacture'],
                        'jour'=> $jours,
                        'nbr_jour'=>$date_client

                    ];

                }
            }

           
       }
   }

   $resultat_select =array($date_une_sem,$resul_obt);
   echo json_encode($resultat_select);
  
}


if (isset($_POST['SELECT_ALL_CHAMBRE'])){


    if (isset($_POST['id_chambre'])) {
        $id_chambre = $_POST['id_chambre'];
        $requette = "SELECT `id_chambre`, `num_chambre`, `description`, `type`, `tarifNuite` FROM `chambre` WHERE `id_chambre`='$id_chambre'";
    } else {

            }

    select_all($requette);
}
