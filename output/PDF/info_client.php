<?php


header('Content-Type: text/html; charset=utf-8');

require_once '../../config/db_config.php';

require_once '../../assets/vendor/tcpdf_min/tcpdf.php';




// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {

    //Page header
    public function Header() {

        // Logo 
        //$this->Image($image, 10, 10, 25, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        // Set font
//        $this->SetFont('times', 'B', 16);
        // Title
//        $this->Cell(0, 15, ' CERTIFICAT DE SCOLARITE ', 0, false, 'C', 0, '', 0, false, 'M', 'M');
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('times', 'G', 7);
        // Page number
//        $this->Cell(0, 20, 'Avis important: Il ne peut être délivré qu’un seul exemplaire du présent relevé de notes. Aucun duplicata ne sera fourni.', 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }

    /**
     * @param bool $destroyall
     * @param bool $preserve_objcopy
     */
    public function _destroy($destroyall = false, $preserve_objcopy = false) {
        if ($destroyall) {
            unset($this->imagekeys);
        }
        parent::_destroy($destroyall, $preserve_objcopy);
    }

}




$obj_pdf = new MYPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$obj_pdf->SetCreator(PDF_CREATOR);
$obj_pdf->SetAuthor('Magic-appli');
$obj_pdf->SetTitle("INFORMATIONS");
$obj_pdf->SetKeywords('ARTISANT_DRAM');
$obj_pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);
$obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$obj_pdf->SetDefaultMonospacedFont('times');
$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
$obj_pdf->SetMargins(PDF_MARGIN_LEFT, '5', PDF_MARGIN_RIGHT);
$obj_pdf->setPrintHeader(false);
$obj_pdf->setPrintFooter(true);
$obj_pdf->SetAutoPageBreak(TRUE, 10);
$obj_pdf->SetFont('times', '', 11);
$obj_pdf->AddPage();

$obj_pdf->Image('../../assets/image/logo.jpg',30, 20, 30, 20);

$content = "<div>";

$id_info = $_GET["id_info"];


$requette = "SELECT reservation.`idClient`, reservation.`num_chambre`, reservation.`forfait`, reservation.`dateArrivee`, reservation.`dateDepart`,
         `num_chambre`,reservation.`societe`, reservation.`tarifNuite`, reservation.`refBar`,
          reservation.`montantBar`, reservation.`refRestaurant`, reservation.`montantRestaurant`, 
          reservation.`refFrigo`, reservation.`montantFrigo`, reservation.`refLingerie`, 
          reservation.`montantLingerie`, reservation.`refLocation`, reservation.`montantLocation`, 
          reservation.`refNuite`, reservation.`montantNuite`, reservation.`totalJour`,
          reservation.`totalFacture`, client.`nomClient`, client.`prenom`, client.`dateNais`,
           client.`lieuNais`, client.`pere`, client.`mere`, client.`type`, client.`profession`, client.`nationalite`, 
           client.`domicileExacte`, client.`telephone`, client.`photocopieCIN`, client.`photocopiePasseport`, client.`statut`
            FROM `client`
                           LEFT JOIN reservation ON reservation.`idClient`= client.`idClient` WHERE client.`idClient`='$id_info'";

$resultat = '';

        // echo $requette;
        $resultat = $mysqli->query($requette);
    
        // $resul_obt = array();
    
        // if ($resultat->num_rows > 0) {
        //     while ($row = $resultat->fetch_assoc()) {
        //         $resul_obt[] = $row;
        //     }
        // &nbsp;}
foreach($resultat as $row){
    $nom = $row["nomClient"];
    $prenom = $row["prenom"];
    $datenais = $row['dateNais'];
    $lieunais = $row['lieuNais'];
    $type = $row['type'];
    $pere = $row['pere'];
    $mere = $row['mere'];
    $telephone = $row['telephone'];
    $nationalite = $row['nationalite'];
    $domicile = $row['domicileExacte'];
    $profession = $row['profession'];


    $numchambre = $row['num_chambre'];
    $forfait = $row['forfait'];
    $societe = $row['societe'];
    $arrive = $row['dateArrivee'];
    $tarifnuite = $row['tarifNuite'];
    $refbar = $row['refBar'];
    $refrest = $row['refRestaurant'];
    $reffrigo = $row['refFrigo'];
    $reflinge = $row['refLingerie'];
    $refloca = $row['refLocation'];
    $refnuite = $row['refNuite'];
    $totaljour = $row['totalJour'];
    $montantbar =$row['montantBar'];
    $montantrest = $row['montantRestaurant'];
    $montantfrigo = $row['montantFrigo'];
    $montantlinge = $row['montantLingerie'];
    $montantloca = $row['montantLocation'];
    $montantnuite = $row['montantNuite'];
    $totalfac = $row['totalFacture'];
    $cin = $row['photocopieCIN'];
    $passeport = $row['photocopiePasseport'];


    $content .="
    <div></div>
    <div>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    Hotel de la poste Antsiranana

    <br>

    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    ******************************************************
    </div>
    <div></div>

    <h2>Informations du client</h2> <br>
   
    
<table border=1>
<tr>
    <td style='width: 60%;'>Nom &nbsp;et &nbsp; Prenom</td> <td>  $nom $prenom</td>
</tr>
<tr>
    <td style='width: 60%;'>Date&nbsp;et&nbsp;lieu&nbsp;de&nbsp;naissance</td> <td> : $datenais à $lieunais</td>
</tr>
<tr>
    <td style='width: 60%;'>Type</td> <td> : $type</td>
</tr>
<tr>
    <td style='width: 60%;'>Nom du père</td> <td> : $pere</td>
</tr>
<tr>
    <td style='width: 60%;'>Nom&nbsp;de &nbsp;la &nbsp;mère</td> <td> : $mere</td>
</tr>
<tr>
    <td style='width: 60%;'>Téléphone</td> <td> : $telephone</td>
</tr>
<tr>
    <td style='width: 60%;'>Nationalité</td> <td> : $nationalite</td>
</tr>
<tr>
    <td style='width: 60%;'>Domicile&nbsp;exacte</td> <td> : $domicile</td>
</tr>
<tr>
    <td style='width: 60%;'>Profession</td> <td> : $profession</td>
</tr>
 
</table>


    <h2>Informations du chambre</h2><br>


    <table border=1>
        <tr>
            <td style='width: 60%;'>Forfait</td> <td> : $numchambre</td>
        </tr>
        <tr>
            <td style='width: 60%;'>Société</td> <td> : $societe</td>
        </tr>
        <tr>
            <td style='width: 60%;'>Date d'arrivée</td> <td> : $arrive</td>
        </tr>
        <tr>
            <td style='width: 60%;'>Tarif nuité</td> <td> : $tarifnuite</td>
        </tr>
        <tr>
            <td style='width: 60%;'>Référence bar</td> <td> : $refbar</td>
        </tr>
        <tr>
            <td style='width: 60%;'>Référence restaurant</td> <td> : $refrest</td>
        </tr>
        <tr>
            <td style='width: 60%;'>Référence frigo</td> <td> : $reffrigo</td>
        </tr>
        <tr>
            <td style='width: 60%;'>Référence lingerie</td> <td> : $reflinge</td>
        </tr>
        <tr>
            <td style='width: 60%;'>Référence location</td> <td> : $refloca</td>
        </tr>
        <tr>
            <td style='width: 60%;'>Référence nuité</td> <td> : $refnuite</td>
        </tr>
        <tr>
            <td style='width: 60%;'>Total jour</td> <td> : $totaljour</td>
        </tr>
        <tr>
            <td style='width: 60%;'>Montant bar</td> <td> : $montantbar</td>
        </tr>
        <tr>
            <td style='width: 60%;'>Montant restaurant</td> <td> : $montantrest</td>
        </tr>
        <tr>
            <td style='width: 60%;'>Montant Frigo</td> <td> : $montantfrigo</td>
        </tr>
        <tr>
            <td style='width: 60%;'>Montant lingerie</td> <td> : $montantlinge</td>
        </tr>
        <tr>
            <td style='width: 60%;'>Montant location</td> <td> : $montantloca</td>
        </tr>
        <tr>
            <td style='width: 60%;'>Montant nuité</td> <td> : $montantnuite</td>
        </tr>
        <tr>
            <td style='width: 60%;'>Total Facture</td> <td> : $totalfac</td>
        </tr>
    </table>
    

<div></div>
<div></div>
<div></div>
<div></div>
<div>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Fait Antsiranana le ". date("d - m - Y")."</div>

    

    ";
    
}

// echo $content;

$content .="</div>";
$obj_pdf->writeHTML($content);

$obj_pdf->Output('Client.pdf', 'I');
?>
