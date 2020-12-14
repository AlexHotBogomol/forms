<?php
  $currentDirectory = getcwd();
  $id = $_POST['id'];
  $uploadDirectory =  $_SERVER['DOCUMENT_ROOT'] . '/uploads/';
  $uploadSubDirectory =  $uploadDirectory . $id ;
  
  $error = false;
  
  function pcgbasename($param, $suffix=null) {
    if ( $suffix ) {
      $tmpstr = ltrim(substr($param, strrpos($param, DIRECTORY_SEPARATOR) ), DIRECTORY_SEPARATOR);
      if ( (strpos($param, $suffix)+strlen($suffix) )  ==  strlen($param) ) {
        return str_ireplace( $suffix, '', $tmpstr);
      } else {
        return ltrim(substr($param, strrpos($param, DIRECTORY_SEPARATOR) ), DIRECTORY_SEPARATOR);
      }
    } else {
      return ltrim(substr($param, strrpos($param, DIRECTORY_SEPARATOR) ), DIRECTORY_SEPARATOR);
    }
  }
  
  $fileExtensionsAllowed = ['jpeg','jpg','png']; // These will be the only file extensions allowed
  
  $fileName = $_FILES['file']['name'];
  $fileSize = $_FILES['file']['size'];
  $fileTmpName  = $_FILES['file']['tmp_name'];
  $fileType = $_FILES['file']['type'];
  // $fileExtension = strtolower(end(explode('.',$fileName)));
  
  $uploadPath = $uploadSubDirectory . '/' . pcgbasename($fileName);
  
  // if (! in_array($fileExtension,$fileExtensionsAllowed)) {
  //   $errors[] = "This file extension is not allowed. Please upload a JPEG or PNG file";
  // }
  
  if ($fileSize > 10000000) {
    $error = "Datei überschreitet maximale Größe (10 MB)";
  }
  
  if (!$error) {
    
    if (!file_exists($uploadSubDirectory)) {
      mkdir($uploadSubDirectory, 0777, true);
    }
    
    $didUpload = move_uploaded_file($fileTmpName, $uploadPath);
    
    if ($didUpload) {
      echo "The file " . pcgbasename($fileName) . " has been uploaded";
    } else {
      echo "An error occurred. Please contact the administrator.";
    }
  } else {
    header('HTTP/1.1 400 Bad Request');
    header('Content-Type: application/json; charset=UTF-8');
    die(json_encode($error));
  }

?>