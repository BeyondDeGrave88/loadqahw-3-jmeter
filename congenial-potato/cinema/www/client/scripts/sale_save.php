<?php
  require $_SERVER['DOCUMENT_ROOT'] . '/config/autoloader.php';
  session_start();

  // Подключение к БД
  if (!isset($_SESSION['database'])) {
    $_SESSION['database'] = new Database();
  }

  // Проверка целостности данных хранящихся в сессии
  if ((!isset($_SESSION['Reservation'])) || (!isset($_SESSION['QRtext'])) || 
     (!isset($_SESSION['sale'])) || (!isset($_SESSION['sales'])) || (!isset($_SESSION['hallConfiguration']))) {
      exit;
  }

  if (isset($_SESSION['sale']['sale_id'])) {
    $query = "UPDATE `" . DB_NAME . "`.`sales` SET `sale_configuration` = '" . $_SESSION['hallConfiguration'] . "'  WHERE `sales`.`sale_id` =" . $_SESSION['sale']['sale_id'];
  } else {
    $query = "INSERT INTO `" . DB_NAME . "`.`sales` (`sale_id`, `sale_timestamp`, `sale_hallid`, `sale_seanceid`, `sale_configuration`) VALUES (null, '" . $_SESSION['sale']['sale_timestamp'] . "', '" . $_SESSION['sale']['sale_hallid'] . "', '" . $_SESSION['sale']['sale_seanceid'] . "', '" . $_SESSION['hallConfiguration'] . "');";       
  }
  $response = array($_SESSION['database']->mysqlQuery($query));
  // Если ошибки нет обновляем список продаж
  if (!$response[0]["err"]) {
    $response = $_SESSION['database']->updateSales();
    if (!$response['err']) {
      $_SESSION['sales'] = $response['result'];
    }
  }

  unset($_SESSION['sale']);
  header("Location: ../ticket.php");

?>