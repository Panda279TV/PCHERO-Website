<?php
// Wenn der File abgeschickt wurde, also nicht leer ist, dann führe den Code unten aus
// Die error Variable wird auf false gesetzt, falche Dateien hochlädt, wird die Variable auf true gesetzt und so kommt man nicht weiter
if(!empty($_FILES['images'])) {
//if(!empty($_POST)) {
  $error = false;

// Schaut was die hochgeladene Datei alles mit gibt
// echo '<pre>';
// var_dump($_FILES);
// echo '</pre>';

  // Der FileName, die Extension und das Array mit den Endungen werden in Variablen gespeichert
  $fileName = pathinfo($_FILES['image']['name'], PATHINFO_FILENAME);
  $extension = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
  $allowedImageEnding = array('png', 'jpg', 'jpeg');
  
  // Schauen was genau bei dem FileName und der extension Variable herauskommt
  // var_dump($fileName);
  // var_dump($extension);

  // Schaut ob die Endungen in dem FileName vorhanden ist, falls nicht, kommt eine Fehlermeldung
  if(!in_array($extension, $allowedImageEnding)) {
      echo "<br>Invalid file extension. Only png, jpg, jpeg files are allowed!";
      $error = true;
  } 

  // Die FileGröße und die maximale KB Größe werden in Variablen gespeichert
  $fileSize = $_FILES['image']['size'];
  $maxSize = 5000*1024;
  // Schauen was genau die FileGröße ist
  // echo $fileSize;

  // Ist die FileGröße grüßer als die maximale Größe, dann zeige bitte eine Fehlermeldung an
  if($fileSize > $maxSize) {
      echo "<br>Please do not upload files larger than 1.000kb!";
      $error = true;
  }

  // Speichert den FilePfad, UploadOrdner und den neuen Pfad in Variablen
  $filePath = $_FILES['image']['tmp_name'];
  $uploadFolder = 'img/db-uploads/';
  $newPath = $uploadFolder.$fileName.'.'.$extension;
  // Schaut was bei den FilePfad und neuenPfad herauskommt
  // echo $filePath;
  // echo $newPath;

  // Wenn der neue Pfad schon existiert, dann füge hintenr den FileNamen eine Nummer dran und wiederhole das die ganze Zeit
  // test, test#1, test#2, test#3, etc.
  if(file_exists($newPath)) {
   $id = 1;
   do {
   $newPath = $uploadFolder.$fileName.'#'.$id.'.'.$extension;
   $id++;
   } while(file_exists($newPath));
  }

    // Wenn oben alles richtig ist und kein $error = true ist, dann bewege die Datei in den Upload Ordner mit dem Namen, wie die Datei hochgeladen wurde
    if (!$error) {
        move_uploaded_file ($filePath , $newPath);
    }
}
?>