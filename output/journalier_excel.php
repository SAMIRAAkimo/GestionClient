<?php

require_once('../assets/vendor/phpExcel/Classes/PHPExcel.php');
require_once '../config/db_config.php';

$date = date("Y-m-d-h-m-s");

$day = $_GET['jour']?$_GET['jour']: date('d-m-Y') ;
$start_day = date("d-m-Y", strtotime($day));

$logo_art = './logo/logo2.png';
$logo_republique = './logo/logo1.png';

$objPHPExcel = new PHPExcel();

$objPHPExcel->setActiveSheetIndex(0);

$objPHPExcel->getActiveSheet()->getStyle("A:Z")->getFont()->setSize(13);

$objPHPExcel->getActiveSheet()->setTitle("Planning journalier");

$query = "SELECT `id_chambre`, `num_chambre`, `description`, `type`, `tarifNuite`  FROM `chambre` ORDER BY `chambre`.`num_chambre` ASC";

$resultatChambre = $mysqli->query($query);

$bool = true;

$initial = 6;
$decalage = $initial;

$nbr_chambre = 0;

foreach ($resultatChambre as $row_chambre) {
$nbr_chambre++;
}

$chbr_occupe = 0;
$nb_arrive = 0;
$nb_depart = 0;
$nb_nuite = 0;

$objPHPExcel->getActiveSheet()->setCellValue("C1", "Planning journalier du : " . $start_day);

$objPHPExcel->getActiveSheet()->setCellValue("A" . $decalage, 'ch');
$objPHPExcel->getActiveSheet()->setCellValue("B" . $decalage, 'Type');
$objPHPExcel->getActiveSheet()->setCellValue("C" . $decalage, 'Client');
$objPHPExcel->getActiveSheet()->setCellValue("D" . $decalage, 'Catégorie');
$objPHPExcel->getActiveSheet()->setCellValue("E" . $decalage, 'Arrivée');
$objPHPExcel->getActiveSheet()->setCellValue("F" . $decalage, 'Nb Nuitées');
$objPHPExcel->getActiveSheet()->setCellValue("G" . $decalage, 'Forfait');
$objPHPExcel->getActiveSheet()->setCellValue("H" . $decalage, 'Description');

$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(40);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(25);

foreach ($resultatChambre as $row_chambre) {

  // echo $row_chambre['num_chambre'].'=='.$row_chambre['type'].'<br>';
  $decalage++;
  $objPHPExcel->getActiveSheet()->setCellValue("A" . $decalage, $row_chambre['num_chambre']);
  $num_chbr = $row_chambre['num_chambre'];

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

      $jours = '';
      $date_client = array();
      for ($c = 0; $row_client['totalJour'] > $c; $c++) {
        $date_client[] = (date("d-m-Y", strtotime($row_client['dateArrivee'] . ' + ' . $c . ' days')));
      }

      for ($n = 0; $n < count($date_client); $n++) {
        if ($start_day == $date_client[$n]) {

          $chbr_occupe = $chbr_occupe + 1;

          $objPHPExcel->getActiveSheet()->setCellValue("B" . $decalage, $row_chambre['type']);
          $objPHPExcel->getActiveSheet()->setCellValue("C" . $decalage, $row_client['nomClient'] . ' ' . $row_client['prenom']);
          $objPHPExcel->getActiveSheet()->setCellValue("D" . $decalage, $row_client['type']);
          $objPHPExcel->getActiveSheet()->setCellValue("E" . $decalage,date("d-m-Y",strtotime($row_client['dateArrivee'])) );
          $objPHPExcel->getActiveSheet()->setCellValue("F" . $decalage, $row_client['totalJour']);
          $objPHPExcel->getActiveSheet()->setCellValue("G" . $decalage, $row_client['forfait']);
          $objPHPExcel->getActiveSheet()->setCellValue("H" . $decalage, $row_chambre['description']);

          if ($start_day == date("d-m-Y", strtotime($row_client['dateArrivee']))) {

            $nb_arrive = $nb_arrive + 1;
            $objPHPExcel->getActiveSheet()->getStyle("A" . $decalage)->getFill()->applyFromArray(array(
              'type' => PHPExcel_Style_Fill::FILL_SOLID,
              'startcolor' => array(
                'rgb' => '49b822'
              )
            ));
            // echo $row_client['dateArrivee'].'=='.$row_client['nomClient'].'==0 <br>';
          }else{
            
          }
          
          if ($start_day == date("d-m-Y", strtotime($row_client['dateDepart']))) {

            $nb_depart = $nb_depart + 1;
            $objPHPExcel->getActiveSheet()->getStyle("A" . $decalage)->getFill()->applyFromArray(array(
              'type' => PHPExcel_Style_Fill::FILL_SOLID,
              'startcolor' => array(
                'rgb' => 'c75170'
              )
            ));
            // echo $row_client['dateDepart'].'=='.$row_client['nomClient'].'==1 <br>';

          }
         
          if (($start_day != strtotime($row_client['dateDepart'])) && ($start_day != date("d-m-Y", strtotime($row_client['dateArrivee'])))) {

            $objPHPExcel->getActiveSheet()->getStyle("A" . $decalage)->getFill()->applyFromArray(array(
              'type' => PHPExcel_Style_Fill::FILL_SOLID,
              'startcolor' => array(
                'rgb' => '4ae8e6'
              )
            ));
            // echo $row_client['dateArrivee'].'****'.$row_client['dateDepart'].'=='.$row_client['nomClient'].'==2 <br>';

          }

          if ($start_day != $row_client['dateDepart']) {

            $nb_nuite = $nb_nuite + 1;
          }
        }
      }
    }
  }
}

$objPHPExcel->getActiveSheet()->getStyle("A6:Z6")->getFont()->setSize(15);
$objPHPExcel->getActiveSheet()->getStyle("A6:A" . $decalage)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle("F6:F" . $decalage)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle("A6:H6")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle("A6:H6")->getFill()->applyFromArray(array(
  'type' => PHPExcel_Style_Fill::FILL_SOLID,
  'startcolor' => array(
    'rgb' => 'FFFF00'
  )
));

$BStyle = array(
  'borders' => array(
    'allborders' => array(
      'style' => PHPExcel_Style_Border::BORDER_THIN
    )
  )
);
$objPHPExcel->getActiveSheet()->getStyle("A6:" . "H" . $decalage)->applyFromArray($BStyle);
$objPHPExcel->getActiveSheet()->getStyle("A6:H6")->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle("C1")->getFont()->setBold(true);

// $objPHPExcel->getActiveSheet()->getStyle("A6", "H" . $decalage)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
// $objPHPExcel->getActiveSheet()->getStyle("A6:H" . ($decalage))->applyFromArray($BStyle);

$objPHPExcel->getActiveSheet()->setCellValue("B2", "Ch libres : " . ($nbr_chambre - $chbr_occupe));
$objPHPExcel->getActiveSheet()->setCellValue("E2", "Ch occupées : " . $chbr_occupe);
$objPHPExcel->getActiveSheet()->setCellValue("B3", "Nb arrivées : " . $nb_arrive);
$objPHPExcel->getActiveSheet()->setCellValue("E3", "Nb depart : " . $nb_depart);
$objPHPExcel->getActiveSheet()->setCellValue("B4", "Nb nuitées : " . $nb_nuite);
$objPHPExcel->getActiveSheet()->mergeCells('B2:C2');
$objPHPExcel->getActiveSheet()->mergeCells('E2:F2');
$objPHPExcel->getActiveSheet()->mergeCells('B3:C3');
$objPHPExcel->getActiveSheet()->mergeCells('E3:F3');
$objPHPExcel->getActiveSheet()->mergeCells('B4:C4');

// $objPHPExcel->getActiveSheet()->getStyle("B8:D14")->getFont()->setSize(12);

// $objPHPExcel->getActiveSheet()->getStyle("G7")->getFont()->setSize(18);

// $objPHPExcel->getActiveSheet()->getStyle("A")->getAlignment()->setWrapText(true);

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Planning_journalier-' . $start_day . '.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

$objWriter->save('php://output');
