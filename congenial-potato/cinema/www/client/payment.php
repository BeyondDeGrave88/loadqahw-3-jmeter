<?php
    require $_SERVER['DOCUMENT_ROOT'] . '/config/autoloader.php';
    session_start();

    // Проверка целостности данных хранящихся в сессии
    if ((!isset($_SESSION['film'])) || (!isset($_SESSION['seance'])) || 
       (!isset($_SESSION['hall'])) || (!isset($_SESSION['sale']))) {
        include 'index.php';
        exit;
    }

    $date = date('d-m-Y', $_SESSION['sale']['sale_timestamp']);
    $filmName = $_SESSION['film']['film_name'];
    $seanceStart =  $_SESSION['seance']['seance_time'];
    $hallName = $_SESSION['hall']['hall_name'];
    $priceStandart = $_SESSION['hall']['hall_price_standart'];
    $priceVip = $_SESSION['hall']['hall_price_vip'];

    if (isset($_SESSION['salesPlaces'])) {
      $cost = 0;
      $places ="";
      foreach($_SESSION['salesPlaces'] as $place) {
        $placeArray = (array)$place;
        if ($placeArray ['type'] == "standart") {$cost += $priceStandart;}
        if ($placeArray ['type'] == "vip") {$cost += $priceVip;}
        if ($places != "") {$places .= ", ";}
        $places .= $placeArray ['row'] . "/" . $placeArray ['place'];
      }
    }

    $_SESSION['Reservation']  = array('date' => $date, 
                                      'filmName' => $filmName,
                                      'seanceStart' => $seanceStart,
                                      'hallName' => $hallName,
                                      'places' => $places);

    $QRtext = "Фильм: " . $filmName . PHP_EOL . "Зал: "  . $hallName . PHP_EOL . "Ряд/Место: " . $places . PHP_EOL . "Дата: " . $date . PHP_EOL . "Начало сеанса: " . $seanceStart . PHP_EOL . "Билет действителен строго на свой сеанс";
    $_SESSION['QRtext'] = $QRtext;

?>

<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>ИдёмВКино</title>
  <link rel="stylesheet" href="css/normalize.css">
  <link rel="stylesheet" href="css/styles.css">
  <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900&amp;subset=cyrillic,cyrillic-ext,latin-ext" rel="stylesheet">
</head>

<body>
  <header class="page-header">
    <h1 class="page-header__title">Идём<span>в</span>кино</h1>
  </header>
  
  <main>
    <section class="ticket">
      
      <header class="tichet__check">
        <h2 class="ticket__check-title">Вы выбрали билеты:</h2>
      </header>
      <div class="ticket__info-wrapper">
        <p class="ticket__info">На фильм: <span class="ticket__details ticket__title"><?php echo $filmName; ?></span></p>
        <p class="ticket__info">Ряд/Место: <span class="ticket__details ticket__chairs"><?php echo $places; ?></span></p>
        <p class="ticket__info">В зале: <span class="ticket__details ticket__hall"><?php echo $hallName; ?></span></p>
        <p class="ticket__info">Дата: <span class="ticket__details ticket__hall"><?php echo $date; ?></span></p>
        <p class="ticket__info">Начало сеанса: <span class="ticket__details ticket__start"><?php echo $seanceStart; ?></span></p>
        <p class="ticket__info">Стоимость: <span class="ticket__details ticket__cost"><?php echo $cost; ?></span> руб.</p>

        <button class="acceptin-button" onclick="location.href='scripts/sale_save.php'" >Получить код бронирования</button>

        <p class="ticket__hint">После оплаты билет будет доступен в этом окне, а также придёт вам на почту. Покажите QR-код нашему контроллёру у входа в зал.</p>
        <p class="ticket__hint">Приятного просмотра!</p>
      </div>
    </section>     
  </main>
  
</body>
</html>