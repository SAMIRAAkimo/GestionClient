<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/* exporter le fichier excel */


class colForEC {

    private $code_ue;
    private $code_ec;
    private $periode;
    private $indexColonne;

    function getCode_ue() {
        return $this->code_ue;
    }

    function getCode_ec() {
        return $this->code_ec;
    }

    function getPeriode() {
        return $this->periode;
    }

    function getIndexColonne() {
        return $this->indexColonne;
    }

    function setCode_ue($code_ue) {
        $this->code_ue = $code_ue;
    }

    function setCode_ec($code_ec) {
        $this->code_ec = $code_ec;
    }

    function setPeriode($periode) {
        $this->periode = $periode;
    }

    function setIndexColonne($indexColonne) {
        $this->indexColonne = $indexColonne;
    }

}

class colForMoyenne {

    private $type;
    private $code_periode;
    private $indexColonne;

    function getType() {
        return $this->type;
    }

    function getCode_periode() {
        return $this->code_periode;
    }

    function getIndexColonne() {
        return $this->indexColonne;
    }

    function setType($type) {
        $this->type = $type;
    }

    function setCode_periode($code_periode) {
        $this->code_periode = $code_periode;
    }

    function setIndexColonne($indexColonne) {
        $this->indexColonne = $indexColonne;
    }

}

class indexTotalUE {

    private $code_ue;
    private $sigle_ue;
    private $indexColonne;
    private $Code_periode;
    
    function getCode_periode() {
        return $this->Code_periode;
    }

    function setCode_periode($Code_periode) {
        $this->Code_periode = $Code_periode;
    }

    
    public function setSigle_ue($sigle_ue) {
        $this->sigle_ue = $sigle_ue;
    }

    public function setCode_ue($Code_ue) {
        $this->code_ue = $Code_ue;
    }

    public function setIndexColonne($indexColonne) {
        $this->indexColonne = $indexColonne;
    }

    public function getCode_ue() {
        return $this->code_ue;
    }

    public function getIndexColonne() {
        return $this->indexColonne;
    }

    public function getSigle_ue() {
        return $this->sigle_ue;
    }

}

class studentValidation {

    private $matricule;
    private $code_periode;
    private $nom;
    private $isValide;
    private $isUE_elimine;
    private $isEC_elimine;
    private $arrayUE_elimine = array();
    private $arrayEC_elimine = array();
    private $arrayEC_invalide = array();
    private $resultatDeliberation;
    private $thisClasseSame;
    private $moyenneGeneral;
            
    function getMoyenneGeneral() {
        return $this->moyenneGeneral;
    }

    function setMoyenneGeneral($moyenneGeneral) {
        $this->moyenneGeneral = $moyenneGeneral;
    }
 
    function getThisClasseSame() {
        return $this->thisClasseSame;
    }

    function setThisClasseSame($thisClasseSame) {
        $this->thisClasseSame = $thisClasseSame;
    }
 
    function getResultatDeliberation() {
        return $this->resultatDeliberation;
    }

    function setResultatDeliberation($resultatDeliberation) {
        $this->resultatDeliberation = $resultatDeliberation;
    }
 
    function getMatricule() {
        return $this->matricule;
    }

    function setMatricule($matricule) {
        $this->matricule = $matricule;
    }

    function getCode_periode() {
        return $this->code_periode;
    }

    function getNom() {
        return $this->nom;
    }

    function getIsValide() {
        return $this->isValide;
    }

    function setCode_periode($code_periode) {
        $this->code_periode = $code_periode;
    }

    function setNom($nom) {
        $this->nom = $nom;
    }

    function setIsValide($isValide) {
        $this->isValide = $isValide;
    }

    function getIsUE_elimine() {
        return $this->isUE_elimine;
    }

    function getIsEC_elimine() {
        return $this->isEC_elimine;
    }

    function setIsUE_elimine($isUE_elimine) {
        $this->isUE_elimine = $isUE_elimine;
    }

    function setIsEC_elimine($isEC_elimine) {
        $this->isEC_elimine = $isEC_elimine;
    }

    function getArrayEC_elimine() {
        return $this->arrayEC_elimine;
    }

    function setArrayEC_elimine($arrayEC_elimine) {
        $this->arrayEC_elimine = $arrayEC_elimine;
    }
 
    function getArrayUE_elimine() {
        return $this->arrayUE_elimine;
    }

    function getArrayEC_invalide() {
        return $this->arrayEC_invalide;
    }

    function setArrayUE_elimine($arrayUE_elimine) {
        $this->arrayUE_elimine = $arrayUE_elimine;
    }

    function setArrayEC_invalide($arrayEC_invalide) {
        $this->arrayEC_invalide = $arrayEC_invalide;
    }

 
 
}

function array_sort_by_column(&$arr, $col, $dir = SORT_ASC) {
    $sort_col = array();
    foreach ($arr as $key => $row) {
        $sort_col[$key] = $row[$col];
    }

    array_multisort($sort_col, $dir, $arr);
}

function styleCelle($stringCol, $indexCol, $color) {

    global $objPHPExcel;
    centerCell($stringCol, $indexCol);
    $objPHPExcel->getActiveSheet()->getStyle('' . $stringCol . $indexCol . '')->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
            'rgb' => $color
        )
    ));
}

function centerCell($stringCol, $indexCol) {
    global $objPHPExcel;
    $objPHPExcel->getActiveSheet()->getStyle('' . $stringCol . $indexCol . '')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('' . $stringCol . $indexCol . '')->getAlignment()->setWrapText(true);
    $objPHPExcel->getActiveSheet()->getStyle('' . $stringCol . $indexCol . '')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
}

function cellColor($cells, $color) {
    global $objPHPExcel;

    $objPHPExcel->getActiveSheet()->getStyle($cells)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array(
            'rgb' => $color
        )
    ));
}

function cellWhite($cells) {
    global $objPHPExcel;
    $styleArray = array(
        'font' => array(
            'color' => array('rgb' => 'FFFFFF'),
            'name' => 'Calibri',
            'size' => 10
    ));
    $objPHPExcel->getActiveSheet()->getStyle($cells)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle($cells)->getAlignment()->setWrapText(true);
    $objPHPExcel->getActiveSheet()->getStyle($cells)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle($cells)->applyFromArray($styleArray);
    $objPHPExcel->getActiveSheet()->getStyle($cells)->applyFromArray(array(
        'borders' => array(
            'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN
            )
        )
    ));
}

function cellContent($cells) {
    global $objPHPExcel;
    $styleArray = array(
        'font' => array(
            'name' => 'Calibri',
            'size' => 8
    ));

    $objPHPExcel->getActiveSheet()->getStyle($cells)->applyFromArray($styleArray);
}

function getIndexOfEC($arrayEC, $code_ue, $code_ec) {

    foreach ($arrayEC as $value) {
        if ($value->getCode_ue() == $code_ue && $value->getCode_ec() == $code_ec) {
            return $value->getIndexColonne();
            break;
        }
    }
}

function getIndexOfUE($arrayEC, $code_ue, $code_periode) {

    foreach ($arrayEC as $value) {
        if ($value->getCode_ue() === $code_ue && $value->getCode_periode() === $code_periode) {
            return $value->getIndexColonne();
            break;
        }
    }
}

function cellsToMergeByColsRow($start = -1, $end = -1, $row = -1) {
    $merge = 'A1:A1';
    if ($start >= 0 && $end >= 0 && $row >= 0) {
        $start = PHPExcel_Cell::stringFromColumnIndex($start);
        $end = PHPExcel_Cell::stringFromColumnIndex($end);
        $merge = "$start{$row}:$end{$row}";
    }
    return $merge;
}

function getindexOfResultat($arrayEC, $periode, $type) {
    foreach ($arrayEC as $value) {
        if ($value->getCode_periode() === $periode && $type === $value->getType()) {
            return $value->getIndexColonne();
            break;
        }
    }
}

function stringStartsWith($haystack, $needle, $case = true) {
    if ($case) {
        return strpos($haystack, $needle, 0) === 0;
    }
    return stripos($haystack, $needle, 0) === 0;
}


 