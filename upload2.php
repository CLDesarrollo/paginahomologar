<?php

            /* MJFreeway - ERP */
//1. Frontend (/var/www/html/homologar/index.html) subir archivo y guardarlo en el servidor (/var/www/html/homologar/upload.php)
//2. Descargar archivo homologacion  (/var/www/scriptsnode/download.js)
//3. Realizar cruce y completar la informacion (php /var/www/scriptsphp/homologacion.php)
//4. Mover el archivo resultado a el destino


$target_dir = "/var/www/html/homologar/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$FileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Allow certain file formats
if($FileType != "xlsx" ) {
  echo "Sorry, only XLSX/Excel files are allowed.";
  $uploadOk = 0;
}


// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
  // if everything is ok, try to upload file
  } else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
      //echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
      rename($target_file,$target_dir."ReporteMJ2.xlsx" );
      $output = shell_exec('node /var/www/scriptsnode/download.js');  
      $output = shell_exec('php /var/www/scriptsphp/homologacion2.php');  

      $fecha = date('Y_m_d');
      header('Location: http://31.220.62.19/homologar/Entrada_MV_'.$fecha.'.xlsx');
      exit();
    } else {
      echo "Sorry, there was an error uploading your file.";
    }
  }


?>