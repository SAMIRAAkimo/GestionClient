<?php

require_once('../assets/vendor/phpExcel/Classes/PHPExcel.php');
require_once '../config/db_config.php';

function cal($month, $year, $lang, $type)
{

  $numargs = func_num_args();
  if ($numargs == 2) {
    $type = "list";
    $lang = "en";
  }
  if ($numargs == 3) {
    $type = "list";
    $lang = func_get_arg(2);
  }
  if ($numargs >= 4) {
    $type = func_get_arg(3);
    $lang = func_get_arg(2);
  }
  setlocale(LC_TIME, $lang);
  if (checkdate($month, 1, $year) != TRUE)
    return;
  $nbdays = date("t", mktime(0, 0, 0, $month, 1, $year));
  if (strcmp($type, "array") == 0) {
    // recuperation du jour de la semaine ( 0 = dimanche, ... ) 
    $one = date("w", mktime(0, 0, 0, $month, 1, $year));
    // on remplit la 1e ligne avec le nom des jours 
    for ($i = 1; $i <= 7; $i++)
      $c[0][$i - 1] = strftime("%a", mktime(0, 0, 0, 10, $i, 2000));
    // puis on remplit le calendrier 
    for ($i = 1; $i <= $nbdays; $i++)
      $c[(($one + $i - 1) / 7) + 1][($one + $i - 1) % 7] = $i;
    return $c;
  }
  if (strcmp($type, "list") == 0) {
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
$objPHPExcel->getActiveSheet()->getStyle("A:Z")->getFont()->setSize(12);

//change title of sheet feuille
$objPHPExcel->getActiveSheet()->setTitle("Planning mensuel");


$query_chambre = "SELECT `id_chambre`, `num_chambre`, `description`, `type` FROM `chambre` ORDER BY `chambre`.`num_chambre` ASC";

$resultatChambre = $mysqli->query($query_chambre);


$alphabet = [
  'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
  'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK', 'AL', 'AM', 'AN', 'AO', 'AP', 'AQ', 'AR', 'AS', 'AT', 'AU', 'AV', 'AW', 'AX', 'AY', 'AZ',
  'BA', 'BB', 'BC', 'BD', 'BE', 'BF', 'BG', 'BH', 'BI', 'BJ', 'BK', 'BL', 'BM', 'BN', 'BO', 'BP', 'BQ', 'BR', 'BS', 'BT', 'BU', 'BV', 'BW', 'BX', 'BY', 'BZ',
  'CA', 'CB', 'CC', 'CD', 'CE', 'CF', 'CG', 'CH', 'CI', 'CJ', 'CK', 'CL', 'CM', 'CN', 'CO', 'CP', 'CQ', 'CR', 'CS', 'CT', 'CU', 'CV', 'CW', 'CX', 'CY', 'CZ',
  'DA', 'DB', 'DC', 'DD', 'DE', 'DF', 'DG', 'DH', 'DI', 'DJ', 'DK', 'DL', 'DM', 'DN', 'DO', 'DP', 'DQ', 'DR', 'DS', 'DT', 'DU', 'DV', 'DW', 'DX', 'DY', 'DZ',
  'EA', 'EB', 'EC', 'ED', 'EE', 'EF', 'EG', 'EH', 'EI', 'EJ', 'EK', 'EL', 'EM', 'EN', 'EO', 'EP', 'EQ', 'ER', 'ES', 'ET', 'EU', 'EV', 'EW', 'EX', 'EY', 'EZ'
];


$color = [
  'd2cece', '8ab8f2', '02fb1f', 'f8de4f', '1ea82f', '02fbe6', 'c41b43', 'f67f9b', 'd728c5', 'b769b2', '1446e7', '14e73c',
  '378a46', 'fd0107', 'd2cece', '8ab8f2', '02fb1f', 'f8de4f', '1ea82f', '02fbe6', 'b769b2', '1446e7',
  'd2cece', '8ab8f2', '02fb1f', 'f8de4f', '1ea82f', '02fbe6', 'c41b43', 'f67f9b', 'd728c5', 'b769b2', '1446e7', '14e73c',
  'd2cece', '8ab8f2', '02fb1f', 'f8de4f', '1ea82f', '02fbe6', 'c41b43', 'f67f9b', 'd728c5', 'b769b2', '1446e7', '14e73c',
  '378a46', 'fd0107', 'd2cece', '8ab8f2', '02fb1f', 'f8de4f', '1ea82f', '02fbe6', 'b769b2', '1446e7',
  'd2cece', '8ab8f2', '02fb1f', 'f8de4f', '1ea82f', '02fbe6', 'c41b43', 'f67f9b', 'd728c5', 'b769b2', '1446e7', '14e73c',
  'd2cece', '8ab8f2', '02fb1f', 'f8de4f', '1ea82f', '02fbe6', 'c41b43', 'f67f9b', 'd728c5', 'b769b2', '1446e7', '14e73c',
  '378a46', 'fd0107', 'd2cece', '8ab8f2', '02fb1f', 'f8de4f', '1ea82f', '02fbe6', 'b769b2', '1446e7',
  'd2cece', '8ab8f2', '02fb1f', 'f8de4f', '1ea82f', '02fbe6', 'c41b43', 'f67f9b', 'd728c5', 'b769b2', '1446e7', '14e73c',
  'd2cece', '8ab8f2', '02fb1f', 'f8de4f', '1ea82f', '02fbe6', 'c41b43', 'f67f9b', 'd728c5', 'b769b2', '1446e7', '14e73c',
  '378a46', 'fd0107', 'd2cece', '8ab8f2', '02fb1f', 'f8de4f', '1ea82f', '02fbe6', 'b769b2', '1446e7',
  'd2cece', '8ab8f2', '02fb1f', 'f8de4f', '1ea82f', '02fbe6', 'c41b43', 'f67f9b', 'd728c5', 'b769b2', '1446e7', '14e73c',
  'd2cece', '8ab8f2', '02fb1f', 'f8de4f', '1ea82f', '02fbe6', 'c41b43', 'f67f9b', 'd728c5', 'b769b2', '1446e7', '14e73c',
  '378a46', 'fd0107', 'd2cece', '8ab8f2', '02fb1f', 'f8de4f', '1ea82f', '02fbe6', 'b769b2', '1446e7',
  'd2cece', '8ab8f2', '02fb1f', 'f8de4f', '1ea82f', '02fbe6', 'c41b43', 'f67f9b', 'd728c5', 'b769b2', '1446e7', '14e73c',
  'd2cece', '8ab8f2', '02fb1f', 'f8de4f', '1ea82f', '02fbe6', 'c41b43', 'f67f9b', 'd728c5', 'b769b2', '1446e7', '14e73c',
  '378a46', 'fd0107', 'd2cece', '8ab8f2', '02fb1f', 'f8de4f', '1ea82f', '02fbe6', 'b769b2', '1446e7',
  'd2cece', '8ab8f2', '02fb1f', 'f8de4f', '1ea82f', '02fbe6', 'c41b43', 'f67f9b', 'd728c5', 'b769b2', '1446e7', '14e73c',

];

$mois=$_GET['mois'];
$annee=$_GET['annee'];

// $mois = 10;
// $annee = 2022;
$mois_lettre = '';
$out = cal($mois, $annee, 'fr', 'list');

if ($mois == 1) {
  $mois_lettre = "Janvier";
}
if ($mois == 2) {
  $mois_lettre = "Fevrier";
}
if ($mois == 3) {
  $mois_lettre = "Mars";
}
if ($mois == 4) {
  $mois_lettre = "Avril";
}
if ($mois == 5) {
  $mois_lettre = "Mai";
}
if ($mois == 6) {
  $mois_lettre = "Juin";
}
if ($mois == 7) {
  $mois_lettre = "Juillet";
}
if ($mois == 8) {
  $mois_lettre = "Aout";
}
if ($mois == 9) {
  $mois_lettre = "Septembre";
}
if ($mois == 10) {
  $mois_lettre = "Octobre";
}
if ($mois == 11) {
  $mois_lettre = "Novembre";
}
if ($mois == 12) {
  $mois_lettre = "Decembre";
}

$objPHPExcel->getActiveSheet()->setCellValue("H1", $mois_lettre . ' - ' . $annee);

$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight('30');
$objPHPExcel->getActiveSheet()->getStyle('A1:J1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1:J1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1:J1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle("A1:J1")->getFont()->setSize(18);

// *********** maquette fiche + num chambre + date du semaine  *************
$decalage = 3;
$ctr = 1;
for ($cptr = 1, $jour = 2; count($out) >= $cptr; $cptr++, $jour++) {

  $objPHPExcel->getActiveSheet()->setCellValue($alphabet[$jour] . $decalage, substr(ucwords($out[$cptr]), 0, 3) . '-' . $cptr);

  $ctr++;
}
$objPHPExcel->getActiveSheet()->getRowDimension($decalage)->setRowHeight('35');

$objPHPExcel->getActiveSheet()->setCellValue('B' . $decalage, 'Num');

$objPHPExcel->getActiveSheet()->getStyle('B' . $decalage . ':' . $alphabet[$ctr] . $decalage)->getFill()->applyFromArray(array(
  'type' => PHPExcel_Style_Fill::FILL_SOLID,
  'startcolor' => array(
    'rgb' => 'FFFF00'
  )
));

$objPHPExcel->getActiveSheet()->getStyle('B' . $decalage . ':' . $alphabet[$ctr] . $decalage)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('B' . $decalage . ':' . $alphabet[$ctr] . $decalage)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('B' . $decalage . ':' . $alphabet[$ctr] . $decalage)->getFont()->setBold(true);

foreach ($resultatChambre as $row_chambre) {
  $decalage++;
  $num_chbr = $row_chambre['num_chambre'];

  $objPHPExcel->getActiveSheet()->setCellValue('B' . $decalage, $num_chbr);

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
  $id_client = 0;

  $all_array = array();

  if ($resultat_client->num_rows > 0) {
    while ($row_client = $resultat_client->fetch_assoc()) {

      $jours = array();
    
      for ($c = 0; $row_client['totalJour'] >= $c; $c++) {
        $date_client = (date("d-m-Y", strtotime($row_client['dateArrivee'] . ' + ' . $c . ' days')));

        for ($cptr = 1, $jour = 2; count($out) >= $cptr; $cptr++, $jour++) {
          $date_now = ((($cptr<10)? '0'.$cptr :$cptr )) . '-' . $mois . '-' . $annee;
  
          if (trim($date_client) == trim($date_now)) {
 
            $objPHPExcel->getActiveSheet()->setCellValue($alphabet[$jour] . $decalage, $row_client['nomClient'] . ' ' . $row_client['prenom']);

            $a = ($alphabet[$jour] . $decalage);
            $jours[] = $a;

            $nbr = (strlen($row_client['nomClient'] . ' ' . $row_client['prenom']) > 17) ? '50' : '30';
            $objPHPExcel->getActiveSheet()->getRowDimension($decalage)->setRowHeight($nbr);
            $objPHPExcel->getActiveSheet()->getStyle($alphabet[$jour] . $decalage)->getAlignment()->setWrapText(true);
          }
        }
      }
      if (count($jours) > 1) {
        $count = count($jours) - 1;
        $deb = $jours[0];
        $fin = $jours[$count];
        $objPHPExcel->getActiveSheet()->mergeCells($deb . ':' . $fin);
        $objPHPExcel->getActiveSheet()->getStyle($deb . ':' . $fin)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle($deb . ':' . $fin)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


        $objPHPExcel->getActiveSheet()->getStyle($deb . ':' . $fin)->getFill()->applyFromArray(array(
          'type' => PHPExcel_Style_Fill::FILL_SOLID,
          'startcolor' => array(
            'rgb' => $color[$count]
          )
        ));
      } else {
        if (count($jours) == 1) {
          $deb = $jours[0];

          $objPHPExcel->getActiveSheet()->getStyle($deb)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
          $objPHPExcel->getActiveSheet()->getStyle($deb)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

          $objPHPExcel->getActiveSheet()->getStyle($deb)->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
            'rgb' => $color[$count]
            )
          ));
          // echo $count;
        }
      }
    }
  }
}

//************* insertion des client dans les colone ***************

$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="fiche mensuel-'. $mois .'-'. $annee .'.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

$objWriter->save('php://output');
