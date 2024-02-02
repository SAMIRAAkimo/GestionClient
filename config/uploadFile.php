<?php
 
//upload.php
if ($_FILES["file"]["name"] != '') {
 
    $name = $_FILES["file"]["name"];

    $lien = "../File/" . $name;

    if (file_exists($lien)) {
        unlink($lien);
    }
  
    if (move_uploaded_file($_FILES["file"]["tmp_name"], $lien)) {
        echo '1';
    } else {
        echo '0';
    }
 
}
?>