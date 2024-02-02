<?php

require_once('../assets/vendor/phpExcel/Classes/PHPExcel.php');
require_once '../config/db_config.php';

function cal($month , $year , $lang , $type){

   $numargs = func_num_args(); 
   if ($numargs == 2) 
   { 
   $type = "list"; 
   $lang = "en"; 
   } 
   if ($numargs == 3) 
   { 
   $type = "list"; 
   $lang = func_get_arg(2); 
   } 
   if ($numargs >= 4) 
   { 
   $type = func_get_arg(3); 
   $lang = func_get_arg(2); 
   } 
   setlocale(LC_TIME, $lang); 
   if (checkdate($month, 1, $year) != TRUE) 
   return; 
   $nbdays = date("t", mktime(0, 0, 0, $month, 1, $year)); 
   if (strcmp($type, "array") == 0) 
   { 
   // recuperation du jour de la semaine ( 0 = dimanche, ... ) 
   $one = date("w", mktime(0, 0, 0, $month, 1, $year)); 
   // on remplit la 1e ligne avec le nom des jours 
   for ($i = 1; $i <= 7; $i++) 
   $c[0][$i-1] = strftime("%a", mktime(0, 0, 0, 10, $i, 2000)); 
   // puis on remplit le calendrier 
   for ($i = 1; $i <= $nbdays; $i++) 
   $c[(($one+$i-1)/7)+1][($one+$i-1)%7] = $i; 
   return $c; 
   } 
   if (strcmp($type, "list") == 0) 
   { 
   // on remplit la liste avec les jours de la semaine 
   for ($i = 1; $i <= $nbdays; $i++) 
    $l[$i] = strftime("%A", mktime(0, 0, 0, $month, $i, $year)); 
   return $l; 
   
  } 
}


$date = date("Y-m-d-h-m-s");



$logo_art = './logo/logo2.png';
$logo_republique = './logo/logo1.png';

$objPHPExcel = new PHPExcel();

$objPHPExcel->setActiveSheetIndex(0);

//font of text
$objPHPExcel->getActiveSheet()->getStyle("A:Z")->getFont()->setSize(10);

//change title of sheet feuille
$objPHPExcel->getActiveSheet()->setTitle("Planning mensuel");


$query = "SELECT `id_chambre`, `num_chambre`, `description`, `type` FROM `chambre` ORDER BY `chambre`.`num_chambre` ASC";
   
$resultatChambre = $mysqli->query($query);

$semaine =4;
$bool=true;

$initial=6;
$decalage=$initial;


$mois=$_GET['mois'];
$annee=$_GET['annee'];
$mois_lettre='';
$out = cal($mois,$annee, 'fr', 'list');

if($mois==1){$mois_lettre="Janvier";}
if($mois==2){$mois_lettre="Fevrier";}
if($mois==3){$mois_lettre="Mars";}
if($mois==4){$mois_lettre="Avril";}
if($mois==5){$mois_lettre="Mai";}
if($mois==6){$mois_lettre="Juin";}
if($mois==7){$mois_lettre="Juillet";}
if($mois==8){$mois_lettre="Aout";}
if($mois==9){$mois_lettre="Septembre";}
if($mois==10){$mois_lettre="Octobre";}
if($mois==11){$mois_lettre="Novembre";}
if($mois==12){$mois_lettre="Decembre";}

$objPHPExcel->getActiveSheet()->setCellValue("H1", $mois_lettre.' - '.$annee);

$colone=array(

'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'

);

$j=1;
$j_fin=1;
$nbr=0;
$cp=1;


if($out[1]=='mardi'){
  $cp=2;
  $dt= ('1-'.$mois.'-'.$annee);

  $objPHPExcel->getActiveSheet()->setCellValue("B".$decalage, 'lun-'.date("d",strtotime($dt.' - 1 days')));
}
if($out[1]=='mercredi'){
  $cp=3;
  $dt= ('1-'.$mois.'-'.$annee);

  $objPHPExcel->getActiveSheet()->setCellValue("B".$decalage, 'lun-'.date("d",strtotime($dt.' - 2 days')));
  $objPHPExcel->getActiveSheet()->setCellValue("C".$decalage, 'mar-'.date("d",strtotime($dt.' - 1 days')));
}
if($out[1]=='jeudi'){
  $cp=4;
  $dt= ('1-'.$mois.'-'.$annee);

  $objPHPExcel->getActiveSheet()->setCellValue("B".$decalage, 'lun-'.date("d",strtotime($dt.' - 3 days')));
  $objPHPExcel->getActiveSheet()->setCellValue("C".$decalage, 'mard-'.date("d",strtotime($dt.' - 2 days')));
  $objPHPExcel->getActiveSheet()->setCellValue("D".$decalage, 'merc-'.date("d",strtotime($dt.' - 1 days')));
}
if($out[1]=='vendredi'){
  $cp=5;
  $dt= ('1-'.$mois.'-'.$annee);

  $objPHPExcel->getActiveSheet()->setCellValue("B".$decalage, 'lun-'.date("d",strtotime($dt.' - 4 days')));
  $objPHPExcel->getActiveSheet()->setCellValue("C".$decalage, 'mard-'.date("d",strtotime($dt.' - 3 days')));
  $objPHPExcel->getActiveSheet()->setCellValue("D".$decalage, 'merc-'.date("d",strtotime($dt.' - 2 days')));
  $objPHPExcel->getActiveSheet()->setCellValue("E".$decalage, 'jeu-'.date("d",strtotime($dt.' - 1 days')));
}
if($out[1]=='samedi'){
  $cp=6;
  $dt= ('1-'.$mois.'-'.$annee);

  $objPHPExcel->getActiveSheet()->setCellValue("B".$decalage, 'lun-'.date("d",strtotime($dt.' - 5 days')));
  $objPHPExcel->getActiveSheet()->setCellValue("C".$decalage, 'mard-'.date("d",strtotime($dt.' - 4 days')));
  $objPHPExcel->getActiveSheet()->setCellValue("D".$decalage, 'merc-'.date("d",strtotime($dt.' - 3 days')));
  $objPHPExcel->getActiveSheet()->setCellValue("E".$decalage, 'jeu-'.date("d",strtotime($dt.' - 2 days')));
  $objPHPExcel->getActiveSheet()->setCellValue("F".$decalage, 'vend-'.date("d",strtotime($dt.' - 1 days')));
}
if($out[1]=='dimanche'){
  $cp=7;
  $dt= ('1-'.$mois.'-'.$annee);

  $objPHPExcel->getActiveSheet()->setCellValue("B".$decalage, 'lun-'.date("d",strtotime($dt.' - 6 days')));
  $objPHPExcel->getActiveSheet()->setCellValue("C".$decalage, 'mard-'.date("d",strtotime($dt.' - 5 days')));
  $objPHPExcel->getActiveSheet()->setCellValue("D".$decalage, 'merc-'.date("d",strtotime($dt.' - 4 days')));
  $objPHPExcel->getActiveSheet()->setCellValue("E".$decalage, 'jeu-'.date("d",strtotime($dt.' - 3 days')));
  $objPHPExcel->getActiveSheet()->setCellValue("F".$decalage, 'vend-'.date("d",strtotime($dt.' - 2 days')));
  $objPHPExcel->getActiveSheet()->setCellValue("G".$decalage, 'Sam-'.date("d",strtotime($dt.' - 1 days')));
}

// *********** maquette fiche + num chambre + date du semaine  *************


$all_rst = array();
for($cpt=0;$cpt<count($out) ;$cpt++){
  
    // $objPHPExcel->getActiveSheet()->setCellValue("A".$decalage, 'ch');
    
    // for($i=$cp ,$jours=$j_fin ; $i<($j+7) ; $i++ , $jours++){
    //   $objPHPExcel->getActiveSheet()->setCellValue($colone[$cp].$decalage,substr(ucwords($out[$jours]),0,3).'-'.$jours);

    //   // echo $colone[$cp].$decalage.','.substr(ucwords($out[$jours]),0,3).'-'.$jours.'<br>';
    //   $cp=$cp+1;
    // }
    
    foreach ($resultatChambre as $row_chambre) {
      // echo 'a';
      $decalage++;
      $objPHPExcel->getActiveSheet()->setCellValue("A".$decalage, $row_chambre['num_chambre']);
      $num_chbr=$row_chambre['num_chambre'];

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
                           WHERE reservation.`num_chambre` LIKE '%$num_chbr%'";
      
      $resultat_client = '';
        
      $resultat_client = $mysqli->query($requette_client);
  
      if ($resultat_client->num_rows > 0) {
        while ($row_client = $resultat_client->fetch_assoc()) {

            $jours='';
            $date_client = array();
            for($c=0 ; $row_client['totalJour'] > $c;$c++ ){
                $date_client[]=(date("d",strtotime($row_client['dateArrivee'] .' + '.$c.' days')));
                $date_c=(date("d",strtotime($row_client['dateArrivee'] .' + '.$c.' days')));
                if($cpt==$date_c){
                  $all_rst[]=[

                    'num_ch'=> $row_client['num_chambre'],
                    'date'=> $cpt,
                    'nom_client'=> $row_client['nomClient'].' '.$row_client['prenom']
      
                  ];
                }
            }

        }
    }
    }

  
}

// print_r($all_rst);



for($c=0;$c<$semaine ;$c++){
  
  if($bool){
    $objPHPExcel->getActiveSheet()->setCellValue("A".$decalage, 'ch');
    
    for($i=$cp ,$jours=$j_fin ; $i<($j+7) ; $i++ , $jours++){

      $objPHPExcel->getActiveSheet()->setCellValue($colone[$cp].$decalage,substr(ucwords($out[$jours]),0,3).'-'.$jours);

      // echo $colone[$cp].$decalage.','.substr(ucwords($out[$jours]),0,3).'-'.$jours.'<br>';
      $cp=$cp+1;
    }
    $cp=1;
    $j=$jours;

    foreach ($resultatChambre as $row_chambre) {
    
      $decalage++;
      $objPHPExcel->getActiveSheet()->setCellValue("A".$decalage, $row_chambre['num_chambre']);


      // for($y=0; $y<(count($all_rst)) ; $y++){
        
      //   if($all_rst[$y]['num_ch']==$row_chambre['num_chambre']){
          
      //     for($i=$cp ,$jours=$j_fin ; $i<($j+7) ; $i++ , $jours++){

      //         $objPHPExcel->getActiveSheet()->setCellValue($colone[$cp].$decalage,$all_rst[$y]['nom_client']);
            
      //     echo $all_rst[$y]['nom_client'];
      //     // echo "<br><br>";
      //       $cp=$cp+1;
      //     }

      //   }
       
       
      // }
      // echo "<br><br>";
  
    }
    
    $bool=!$bool;
    $j=$jours;
    $cp=1;
    // echo "<br><br>";
  }else{
    $decalage=$initial;
    $cpt=10;
    $objPHPExcel->getActiveSheet()->setCellValue("J".$decalage, 'ch');
    for($i=$j ; $i<($j+7) ; $i++){
      $objPHPExcel->getActiveSheet()->setCellValue($colone[$cpt].$decalage,substr(ucwords($out[$i]),0,3).'-'.$i);
      
      // echo $colone[$cpt].$decalage.','.substr(ucwords($out[$i]),0,3).'-'.$i.'<br>';
      $cpt=$cpt+1;
    }
  
    foreach ($resultatChambre as $row_chambre) {
    
      $decalage++;
      $objPHPExcel->getActiveSheet()->setCellValue("J".$decalage, $row_chambre['num_chambre']);
      
  
    }
    $bool=!$bool;
    $decalage=$decalage+1;
    $initial=$decalage;
    $j_fin=$j+7;
    $j=1;
    $cpt=10;
    
    $nbr=$i;

    // echo "<br><br>";
  }
}

$decalage=$decalage;
$nbr =count($out)- $nbr +1;

// echo $nbr;
if($nbr==0){

}else{

  if($nbr<8){

    $objPHPExcel->getActiveSheet()->setCellValue("A".$decalage, 'ch');
      
    for($i=$cp ,$jours=$j_fin ; $i<($j+$nbr) ; $i++ , $jours++){
      $objPHPExcel->getActiveSheet()->setCellValue($colone[$cp].$decalage,substr(ucwords($out[$jours]),0,3).'-'.$jours);
  
      // echo $colone[$cp].$decalage.','.substr(ucwords($out[$jours]),0,3).'-'.$jours.'<br>';
      $cp=$cp+1;
    }
    
    foreach ($resultatChambre as $row_chambre) {
    
      $decalage++;
      $objPHPExcel->getActiveSheet()->setCellValue("A".$decalage, $row_chambre['num_chambre']);
      
  
    }
    
    $bool=!$bool;
    $j=$jours;
    $cp=1;
   
  }
  
  if($nbr>7){

    if($bool){
      $objPHPExcel->getActiveSheet()->setCellValue("A".$decalage, 'ch');
      
      for($i=$cp ,$jours=$j_fin ; $i<($j+7) ; $i++ , $jours++){
        $objPHPExcel->getActiveSheet()->setCellValue($colone[$cp].$decalage,substr(ucwords($out[$jours]),0,3).'-'.$jours);
  
        // echo $colone[$cp].$decalage.','.substr(ucwords($out[$jours]),0,3).'-'.$jours.'<br>';
        $cp=$cp+1;
      }
      
      foreach ($resultatChambre as $row_chambre) {
      
        $decalage++;
        $objPHPExcel->getActiveSheet()->setCellValue("A".$decalage, $row_chambre['num_chambre']);
        
    
      }
      
      $bool=!$bool;
      $j=$jours;
      $cp=1;
      $nbr=$nbr-7;

      $decalage=$initial;
      $decalage=$decalage;
      $cpt=10;
      $objPHPExcel->getActiveSheet()->setCellValue("J".$decalage, 'ch');
      for($i=$j ; $i<($j+$nbr) ; $i++){
        $objPHPExcel->getActiveSheet()->setCellValue($colone[$cpt].$decalage,substr(ucwords($out[$i]),0,3).'-'.$i);
        
        // echo $colone[$cpt].$decalage.','.substr(ucwords($out[$i]),0,3).'-'.$i.'<br>';
        $cpt=$cpt+1;
      }
    
      foreach ($resultatChambre as $row_chambre) {
      
        $decalage++;
        $objPHPExcel->getActiveSheet()->setCellValue("J".$decalage, $row_chambre['num_chambre']);
        
    
      }

    }

   
  }

}

//************* insertion des client dans les colone ***************

$bool=true;

$initial=6;
$decalage=$initial;
$colone=array(

  'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'
  
  );
  
  $j=1;
  $j_fin=1;
  $nbr=0;
  $cp=1;

  
if($out[1]=='mardi'){
  $cp=2;
  
}
if($out[1]=='mercredi'){
  $cp=3;
  
}
if($out[1]=='jeudi'){
  $cp=4;

}
if($out[1]=='vendredi'){
  $cp=5;
}
if($out[1]=='samedi'){
  $cp=6;
  
}
if($out[1]=='dimanche'){
  $cp=7;
  
}

$decalage=$decalage;
$nbr = count($out)- $nbr +1;

// echo $nbr;
// if($nbr==0){

// }else{

//   if($nbr<8){

//     $objPHPExcel->getActiveSheet()->setCellValue("A".$decalage, 'ch');
      
//     for($i=$cp ,$jours=$j_fin ; $i<($j+$nbr) ; $i++ , $jours++){
//       $objPHPExcel->getActiveSheet()->setCellValue($colone[$cp].$decalage,substr(ucwords($out[$jours]),0,3).'-'.$jours);
  
//       // echo $colone[$cp].$decalage.','.substr(ucwords($out[$jours]),0,3).'-'.$jours.'<br>';
//       $cp=$cp+1;
//     }
    
//     foreach ($resultatChambre as $row_chambre) {
    
//       $decalage++;
//       $objPHPExcel->getActiveSheet()->setCellValue("A".$decalage, $row_chambre['num_chambre']);
      
  
//     }
    
//     $bool=!$bool;
//     $j=$jours;
//     $cp=1;
   
//   }
  
//   if($nbr>7){

//     if($bool){
//       $objPHPExcel->getActiveSheet()->setCellValue("A".$decalage, 'ch');
      
//       for($i=$cp ,$jours=$j_fin ; $i<($j+7) ; $i++ , $jours++){
//         $objPHPExcel->getActiveSheet()->setCellValue($colone[$cp].$decalage,substr(ucwords($out[$jours]),0,3).'-'.$jours);
  
//         // echo $colone[$cp].$decalage.','.substr(ucwords($out[$jours]),0,3).'-'.$jours.'<br>';
//         $cp=$cp+1;
//       }
      
//       foreach ($resultatChambre as $row_chambre) {
      
//         $decalage++;
//         $objPHPExcel->getActiveSheet()->setCellValue("A".$decalage, $row_chambre['num_chambre']);
        
    
//       }
      
//       $bool=!$bool;
//       $j=$jours;
//       $cp=1;
//       $nbr=$nbr-7;

//       $decalage=$initial;
//       $decalage=$decalage;
//       $cpt=10;
//       $objPHPExcel->getActiveSheet()->setCellValue("J".$decalage, 'ch');
//       for($i=$j ; $i<($j+$nbr) ; $i++){
//         $objPHPExcel->getActiveSheet()->setCellValue($colone[$cpt].$decalage,substr(ucwords($out[$i]),0,3).'-'.$i);
        
//         // echo $colone[$cpt].$decalage.','.substr(ucwords($out[$i]),0,3).'-'.$i.'<br>';
//         $cpt=$cpt+1;
//       }
    
//       foreach ($resultatChambre as $row_chambre) {
      
//         $decalage++;
//         $objPHPExcel->getActiveSheet()->setCellValue("J".$decalage, $row_chambre['num_chambre']);
        
    
//       }

//     }

   
//   }

// }

$objPHPExcel->getActiveSheet()->getStyle("B8:D14")->getFont()->setSize(12);

// $objPHPExcel->getActiveSheet()->setCellValue("G".$decalage, "g6");
// $objPHPExcel->getActiveSheet()->setCellValue("C8", "MINISTERE DE L’ARTISANAT ET DES METIERS");
// $objPHPExcel->getActiveSheet()->setCellValue("C9", "--------------------");
// $objPHPExcel->getActiveSheet()->setCellValue("C10", "SECRETARIAT GENERAL");
// $objPHPExcel->getActiveSheet()->setCellValue("C11", "--------------------");
// $objPHPExcel->getActiveSheet()->setCellValue("C12", "DIRECTION REGIIONALE DE L'ARTISANAT ET DES METIERS");
// $objPHPExcel->getActiveSheet()->setCellValue("C13", "--------------------");
// $objPHPExcel->getActiveSheet()->setCellValue("C14", "DIANA");
// $objPHPExcel->getActiveSheet()->getStyle("B8:D14")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

// $objPHPExcel->getActiveSheet()->setCellValue("E15", "FORMALISATION DES ARTISANS");
$objPHPExcel->getActiveSheet()->getStyle("G7")->getFont()->setSize(18);
// $objPHPExcel->getActiveSheet()->getStyle("E15")->getFont()->setBold(true);

// En tete du tableau


// $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
// $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
// $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);


// $objPHPExcel->getActiveSheet()->getStyle("A" . $decalage .":"."S" . $decalage)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
// $objPHPExcel->getActiveSheet()->getStyle("K" . $decalage . ":N" . $decalage)->getFill()->applyFromArray(array(
//   'type' => PHPExcel_Style_Fill::FILL_SOLID,
//   'startcolor' => array(
//       'rgb' => 'FFFF00'
//   )
// ));

// $BStyle = array(
//   'borders' => array(
//     'allborders' => array(
//       'style' => PHPExcel_Style_Border::BORDER_THIN
//     )
//   )
// );
// $objPHPExcel->getActiveSheet()->getStyle("A" . $decalage .":"."S" . $decalage)->applyFromArray($BStyle);
// $objPHPExcel->getActiveSheet()->getStyle("A" . $decalage .":"."S" . $decalage)->getFont()->setBold(true);

// foreach ($results as $row) {

  
//   $autre_pro = $row['autre_profession'];
//   $new_autre_profession = " ";

//   $queryAutreProffession = "SELECT `id_profession`, `libelle_profession` FROM `profession` WHERE id_profession IN(" . $autre_pro . ")";

//   if (!empty($autre_pro)) {

//     $statement = $pdo->prepare($queryAutreProffession);
//     $statement->execute();
//     $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

//     $autre_profession = array();

//     foreach ($rows as $new_row) {

//       $autre_profession[] = $new_row['libelle_profession'];
//     }
//     $new_autre_profession = implode(",", $autre_profession);
//   }
 
//   $nom_artisant =$row['nom_entreprise'];
//   $libelle_region = $row['libelle_region'];
//   $libelle_district = $row['libelle_district'];
//   $libelle_commune = $row['libelle_commune'];
//   $adresse = $row['adresse'];
//   $date_naissance = $row['date_naissance'];
//   $lieu_naissance = $row['lieu_naissance'];
//   $cin = $row['cin'];
//   $contact = $row['contact'];
//   $num_statistique = $row['num_statistique'];
//   $num_nif = $row['num_nif'];
//   $num_cnaps = $row['num_cnaps'];
//   $date_debut_cnaps = $row['date_debut_cnaps'];
//   $libelle_profession = $row['libelle_profession'];
//   $date_debut_profession = $row['date_debut_profession'];
//   $libelle_secteur = $row['libelle_secteur'];
//   $domaine = $row['domaine'];

//   $objPHPExcel->getActiveSheet()->getStyle("A".($decalage + 1).":Z".($decalage + 1))->getFont()->setSize(11);

// $objPHPExcel->getActiveSheet()->setCellValue("A" . ($decalage + 1),($count));
// $objPHPExcel->getActiveSheet()->setCellValue("B" . ($decalage + 1), $nom_artisant);
// $objPHPExcel->getActiveSheet()->setCellValue("C" . ($decalage + 1), " ");
// $objPHPExcel->getActiveSheet()->setCellValue("D" . ($decalage + 1), $date_naissance);
// $objPHPExcel->getActiveSheet()->setCellValue("E" . ($decalage + 1), $lieu_naissance);
// $objPHPExcel->getActiveSheet()->setCellValue("F" . ($decalage + 1), " " . $cin . " ");
// $objPHPExcel->getActiveSheet()->setCellValue("G" . ($decalage + 1), $adresse);
// $objPHPExcel->getActiveSheet()->setCellValue("H" . ($decalage + 1), $libelle_commune);
// $objPHPExcel->getActiveSheet()->setCellValue("I" . ($decalage + 1), $libelle_district);
// $objPHPExcel->getActiveSheet()->setCellValue("J" . ($decalage + 1), $libelle_region);
// $objPHPExcel->getActiveSheet()->setCellValue("K" . ($decalage + 1), " " . $num_statistique . " ");
// $objPHPExcel->getActiveSheet()->setCellValue("L" . ($decalage + 1), " " . $num_nif . " ");
// $objPHPExcel->getActiveSheet()->setCellValue("M" . ($decalage + 1)," " . $num_cnaps . " ");
// $objPHPExcel->getActiveSheet()->setCellValue("N" . ($decalage + 1), $date_debut_profession);
// $objPHPExcel->getActiveSheet()->setCellValue("O" . ($decalage + 1), $libelle_profession);
// $objPHPExcel->getActiveSheet()->setCellValue("P" . ($decalage + 1), $date_debut_profession);
// $objPHPExcel->getActiveSheet()->setCellValue("Q" . ($decalage + 1), $new_autre_profession);
// $objPHPExcel->getActiveSheet()->setCellValue("R" . ($decalage + 1), $libelle_secteur);
// $objPHPExcel->getActiveSheet()->setCellValue("S" . ($decalage + 1), $domaine);

// $objPHPExcel->getActiveSheet()->getStyle("A" . ($decalage + 1) , "S". ($decalage + 1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
// $objPHPExcel->getActiveSheet()->getStyle("A" . ($decalage + 1).":S". ($decalage + 1))->applyFromArray($BStyle);

// $decalage = $decalage+1;
// $count= $count+1;


// }

// logo art//

// $objDrawing = new PHPExcel_Worksheet_Drawing();
// $objDrawing->setPath($logo_art);
// $objDrawing->setCoordinates('C3');
// $objDrawing->setOffsetX(30);
// $objDrawing->setOffsetY(5);
// $objDrawing->setWidth(84);
// $objDrawing->setHeight(79);
// $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

// logo republique //

// $objDrawing = new PHPExcel_Worksheet_Drawing();
// $objDrawing->setPath($logo_republique);
// $objDrawing->setCoordinates('E2');
// $objDrawing->setOffsetX(50);
// $objDrawing->setOffsetY(2);
// $objDrawing->setWidth(383);
// $objDrawing->setHeight(198);
// $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

//FUSION DE CELLULE
// $objPHPExcel->getActiveSheet()->mergeCells('C2:H7');

//ajout de valeur sur le cellule C2
// $objPHPExcel->getActiveSheet()->setCellValue("C2", "UNIVERSITE D'ANTSIRANANA");

// $objPHPExcel->getActiveSheet()->setCellValue("C4", "AZERTY" ); 

$entete = 20;

// $objPHPExcel->getActiveSheet()->setCellValue("A" . $entete, "Date : ");

// $objPHPExcel->getActiveSheet()->setCellValue("B" . $entete, "Cours : ");

//RETOUR A LA LIGNE AUTOMATIQUE
// $objPHPExcel->getActiveSheet()->getStyle("A")->getAlignment()->setWrapText(true);

// //CENTRAGE DE TEXTE CELLULE
// // $objPHPExcel->getActiveSheet()->getStyle("A")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
// // $objPHPExcel->getActiveSheet()->getStyle("A")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

// $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);

// header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
// header('Content-Disposition: attachment;filename="fiche mensuel.xlsx"');
// header('Cache-Control: max-age=0');
// $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

// // // // $objWriter->save(str_replace( __FILE__ , "./Liste Artisants.xlsx", __FILE__));
// $objWriter->save('php://output'); 

