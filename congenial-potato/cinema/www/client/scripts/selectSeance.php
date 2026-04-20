<?php
  require $_SERVER['DOCUMENT_ROOT'] . '/config/autoloader.php';
  session_start();
  if (isset($_SESSION['seance'])) {unset($_SESSION['seance']);};
  if (isset($_SESSION['hall'])) {unset($_SESSION['hall']);};
  if (isset($_SESSION['film'])) {unset($_SESSION['film']);};
  if (isset($_SESSION['sale'])) {unset($_SESSION['sale']);};

  if ((isset($_POST['seanceId'])) && (isset($_POST['seanceTimeStamp']))) {
    foreach($_SESSION['seances'] as $seance) {
      if ($seance['seance_id'] == $_POST['seanceId']) {
        $_SESSION['seance'] = $seance;
        if (isset($_SESSION['halls'])) {
          foreach($_SESSION['halls'] as $hall) {
            if ($hall['hall_id'] == $seance['seance_hallid']) {
              $_SESSION['hall'] = $hall;
              break;
            }
          }
        }
        if (isset($_SESSION['films'])) {
          foreach($_SESSION['films'] as $film) {
            if ($film['film_id'] == $seance['seance_filmid']) {
              $_SESSION['film'] = $film;
              break;
            }
          }
        }     
        break;
      }
    }
    foreach($_SESSION['sales'] as $sale) {
      if (($sale['sale_timestamp'] == $_POST['seanceTimeStamp']) && ($sale['sale_hallid'] == $_SESSION['hall']['hall_id'])) {
        $_SESSION['sale'] = $sale;
        break;
      }
    }
    if (!isset($_SESSION['sale'])) {
      $_SESSION['sale'] = array(
        "sale_timestamp" => $_POST['seanceTimeStamp'],
        "sale_hallid" => $_SESSION['hall']['hall_id'],
        "sale_seanceid" => $_SESSION['seance']['seance_id'],
        "sale_configuration" => str_replace('conf-step', 'buying-scheme', $_SESSION['hall']['hall_config'])
      );
    }
  }


  //===================================================================================================================

  
    // Конфигурация зала
   // $_SESSION['hallConfiguration'] = str_replace('conf-step', 'buying-scheme', $_SESSION['hall']['hall_config']);


  /*  $query = "SELECT * FROM seances WHERE `seance_id`='" . $_POST['seanceId'] . "'";
    $response = array($_SESSION['database']->mysqlQuery($query));
    if (!$response[0]['err']) {
      $_SESSION['seance'] = $response[0]['result'][0];
      $query = "SELECT * FROM halls WHERE `hall_id`='" . $_SESSION['seance']['seance_hallid'] . "'";
      $response = array($_SESSION['database']->mysqlQuery($query));
      if (!$response[0]['err']) {
        $_SESSION['hall'] = $response[0]['result'][0];
      }
      $query = "SELECT * FROM films WHERE `film_id`='" . $_SESSION['seance']['seance_filmid'] . "'";
      $response = array($_SESSION['database']->mysqlQuery($query));
      if (!$response[0]['err']) {
        $_SESSION['film'] = $response[0]['result'][0];
        //print_r($_SESSION['film']);
      }
      $timeStamp = $_SESSION['seance']['seance_start']*60000 + $_POST['timeStampDay'];
      $query = "SELECT * FROM sales WHERE `sales_timestamp`='" . $timeStamp . "' AND `sales_hallid`='" . $_SESSION['seance']['seance_hallid'] . "'";
      $response = array($_SESSION['database']->mysqlQuery($query));
      if (!$response[0]['err']) {
        $_SESSION['sale'] = $response[0]['result'][0];
      }
    }*/
?>