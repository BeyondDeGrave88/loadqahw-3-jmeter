<?php
  require $_SERVER['DOCUMENT_ROOT'] . '/config/autoloader.php';
  session_start();

 

  if (isset($_POST['hallConfiguration'])) {$_SESSION['hallConfiguration'] = str_replace('selected', 'taken', $_POST['hallConfiguration']);};
  if (isset($_POST['salesPlaces'])) {$_SESSION['salesPlaces'] = json_decode($_POST['salesPlaces']);};
 
?>