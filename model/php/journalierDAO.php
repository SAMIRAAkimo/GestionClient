<?php
require_once '../../config/db_config.php';
displayError();

define("success", "success");
define("erreur", "Enregistrement echoue");

$date_now = trim($_POST['date_now']);
$jour = $_POST['jour'];
if(!empty($date_now)){
    
    $date_now = $_POST['date_now'];
    
}else{
   
    $date_now = date('d-m-Y');
    
}

$date_text= date("D-d-M-Y",strtotime($date_now .' '.$jour.' days'));
$start_day = date("d-m-Y",strtotime($date_now .' '.$jour.' days'));

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


if (isset($_POST['SELECT_ALL_JOUR'])) {

    $requetteChambre = "SELECT `id_chambre`, `num_chambre`, `description`, `type`, `tarifNuite` FROM `chambre` ORDER BY `chambre`.`num_chambre` ASC";

    $resultatChambre ='';
   //echo $requette;
   $resultatChambre = $mysqli->query($requetteChambre);

   $resul_obt = array();

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
         client.`lieuNais`, client.`pere`, client.`mere`, client.`type` AS type_client, client.`profession`, client.`nationalite`, 
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
                    for($c=0 ; $row_client['totalJour'] > $c;$c++ ){
                        $date_client[]=(date("d-m-Y",strtotime($row_client['dateArrivee'] .' + '.$c.' days')));
                    }

                    for ($n=0; $n < count($date_client); $n++) { 
                        if($start_day == $date_client[$n]){
                            // echo $start_day .'=='. $date_client[$n].'num='.$row_chambre['num_chambre'].'\n';
                        
                            $resul_obt[]= [
                    
                                'id_client'=>$row_client['idClient'],
                                'num_chambre'=> $row_chambre['num_chambre'],
                                'type'=> $row_chambre['type'],
                                'nom_client'=> $row_client['nomClient'],
                                'prenom'=> $row_client['prenom'],
                                'categorie'=> $row_client['type_client'],
                                'arrive'=>date("d-m-Y",strtotime($row_client['dateArrivee'])),
                                'depart'=>date("d-m-Y",strtotime($row_client['dateDepart'])),
                                'nuite'=>$row_client['totalJour'],
                                'forfait'=>$row_client['forfait'],
                                'desc'=>$row_chambre['description'],
                                // 'jour'=>$jours,
                                'date_now'=>$start_day,
                                'date_now2'=>date("Y-m-d",strtotime($start_day)),
        
                            ];
                        }
                    }

                }
            }

           
       }
   }
   $rst=array($date_text,$resul_obt,date("Y-m-d",strtotime($start_day)));
   echo json_encode($rst);

}


if (isset($_POST['SELECT_ALL_CHAMBRE'])){


    if (isset($_POST['id_chambre'])) {
        $id_chambre = $_POST['id_chambre'];
        $requette = "SELECT `id_chambre`, `num_chambre`, `description`, `type`, `tarifNuite` FROM `chambre` WHERE `id_chambre`='$id_chambre'";
    } else {

            }

    select_all($requette);
}
