<?php
    require $_SERVER['DOCUMENT_ROOT'] . '/config/autoloader.php';
    session_start();

    // Проверка целостности данных хранящихся в сессии
    if ((!isset($_SESSION['film'])) || (!isset($_SESSION['seance'])) || 
       (!isset($_SESSION['hall'])) || (!isset($_SESSION['sale']))) {
        include 'index.php';
        exit;
    }


    $filmName = $_SESSION['film']['film_name'];
    $seanceStart =  $_SESSION['seance']['seance_time'];
    $hallName = $_SESSION['hall']['hall_name'];
    $hallConfiguration = $_SESSION['sale']['sale_configuration'];
    $priceStandart = $_SESSION['hall']['hall_price_standart'];
    $priceVip = $_SESSION['hall']['hall_price_vip'];
?>

<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>ИдёмВКино</title>
  <script src="/client/js/hall.js" defer></script>
  <link rel="stylesheet" href="css/normalize.css">
  <link rel="stylesheet" href="css/styles.css">
  <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900&amp;subset=cyrillic,cyrillic-ext,latin-ext" rel="stylesheet">
</head>

<body>
  <header class="page-header">
    <h1 class="page-header__title">Идём<span>в</span>кино</h1>
  </header>
  
  <main>
    <section class="buying">
      <div class="buying__info">
        <div class="buying__info-description">
          <h2 class="buying__info-title"><?php echo $filmName; ?></h2>
          <p class="buying__info-start">Начало сеанса: <?php echo $seanceStart; ?></p>
          <p class="buying__info-hall"><?php echo $hallName; ?></p>          
        </div>
       <!-- <div class="buying__info-hint">
          <p>Тапните дважды,<br>чтобы увеличить</p>
        </div> -->
      </div>
      <div class="buying-scheme">
        <div class="buying-scheme__wrapper">
          <?php echo $hallConfiguration; ?>
        </div>
        <div class="buying-scheme__legend">
          <div class="col">
            <p class="buying-scheme__legend-price"><span class="buying-scheme__chair buying-scheme__chair_standart"></span> Свободно (<span class="buying-scheme__legend-value"><?php echo $priceStandart; ?></span>руб)</p>
            <p class="buying-scheme__legend-price"><span class="buying-scheme__chair buying-scheme__chair_vip"></span> Свободно VIP (<span class="buying-scheme__legend-value"><?php echo $priceVip; ?></span>руб)</p>            
          </div>
          <div class="col">
            <p class="buying-scheme__legend-price"><span class="buying-scheme__chair buying-scheme__chair_taken"></span> Занято</p>
            <p class="buying-scheme__legend-price"><span class="buying-scheme__chair buying-scheme__chair_selected"></span> Выбрано</p>                    
          </div>
        </div>
      </div>
      <button class="acceptin-button">Забронировать</button>
    </section>     
  </main>
  
</body>
</html>