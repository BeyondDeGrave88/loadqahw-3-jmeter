<?php
    require $_SERVER['DOCUMENT_ROOT'] . '/config/autoloader.php';
    require $_SERVER['DOCUMENT_ROOT'] . '/include/functions.php';
    session_start();

    // Подключение к БД
    if (!isset($_SESSION['database'])) {
      $_SESSION['database'] = new Database();
    }
    // Список активных залов
    if (!isset($_SESSION['halls'])) {
      $query = "SELECT * FROM halls WHERE `hall_open`='1'";
      $response = array($_SESSION['database']->mysqlQuery($query));
      if (!$response[0]['err']) {
        $_SESSION['halls'] = $response[0]['result'];
      } else {
        echo "$response[0]['errMessage']";
        exit;
      }
    }
    // Список фильмов
    if (!isset($_SESSION['films'])) {
      $response = $_SESSION['database']->updateFilms();
      if (!$response['err']) {
        $_SESSION['films'] = $response['result'];
      } else {
        echo $response['errMessage'];
        exit;
      }
    }
    // Список сеансов
    if (!isset($_SESSION['seances'])) {
      $response = $_SESSION['database']->updateSeances();
      if (!$response['err']) {
        $_SESSION['seances'] = $response['result'];
      } else {
        echo $response['errMessage'];
        exit;
      }
    }
    // Удаляем из базы записи о прошедших сеансах
    $query = "DELETE FROM `" . DB_NAME . "`.`sales` WHERE `sales`.`sale_timestamp`<" . time();
    $response = array($_SESSION['database']->mysqlQuery($query));
    if ($response[0]['err']) {
      echo $response[0]['errMessage'];
      exit;
    }

    // Список продаж
    if (!isset($_SESSION['sales'])) {
      $response = $_SESSION['database']->updateSales();
      if (!$response['err']) {
        $_SESSION['sales'] = $response['result'];
      } else {
        echo $response['errMessage'];
        exit;
      }
    }
?>

<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>ИдёмВКино</title>
  <link rel="stylesheet" href="/client/css/normalize.css">
  <link rel="stylesheet" href="/client/css/styles.css">
  <script src="/client/js/index.js" defer></script>
  <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900&amp;subset=cyrillic,cyrillic-ext,latin-ext" rel="stylesheet">
</head>

<body>
  <header class="page-header">
    <h1 class="page-header__title">Идём<span>в</span>кино</h1>
  </header>
  <nav class="page-nav"> 
<?php $chose = 'page-nav__day_today page-nav__day_chosen ';
      for ($i=0; $i<7; $i++) { 
         $weekDayRus = getWeekDayRus((int) $i); ?>
          <a class="page-nav__day <?php echo $chose . $weekDayRus['weekEnd']; ?>" href="#" data-time-stamp="<?php echo $weekDayRus['timeStamp']; ?>">
            <span class="page-nav__day-week"><?php echo $weekDayRus['dayWeek']; ?></span><span class="page-nav__day-number"><?php echo $weekDayRus['day']; ?></span>
          </a>
<?php   $chose = '';
      } ?>
  </nav>
  
  <main>

<?php
  foreach($_SESSION['films'] as $film) {
?>
    <section class="movie">
      <div class="movie__info">
        <div class="movie__poster">
          <img class="movie__poster-image" alt="<?php echo $film['film_name'] ?> постер" src="../img/posters/<?php echo $film['film_id'] ?>.png">
        </div>
        <div class="movie__description">
          <h2 class="movie__title"><?php echo $film['film_name'] ?></h2>
          <p class="movie__synopsis"><?php echo $film['film_description'] ?></p>
          <p class="movie__data">
            <span class="movie__data-duration"><?php echo $film['film_duration'] ?> мин. </span>
            <span class="movie__data-origin"><?php echo $film['film_origin'] ?></span>
          </p>
        </div>
      </div>
      <?php 
        foreach($_SESSION['halls'] as $hall) {
          $seancesForFilm = array_filter($_SESSION['seances'], function($seance) use ($hall, $film)  {
            return (($seance['seance_hallid'] == $hall['hall_id']) && ($seance['seance_filmid'] == $film['film_id']));
          });
          if (count($seancesForFilm)) { ?>
            <div class="movie-seances__hall">
              <h3 class="movie-seances__hall-title"><?php echo $hall['hall_name']; ?></h3>
              <ul class="movie-seances__list">
<?php           foreach($seancesForFilm as $seance) { ?>
                 <li class="movie-seances__time-block"><a class="movie-seances__time" href="#" data-seance-id="<?php echo $seance['seance_id']; ?>" data-seance-start="<?php echo $seance['seance_start']; ?>"><?php echo $seance['seance_time']; ?></a></li>
<?php           }  ?>    
              </ul>
            </div>
<?php     }
        }
      ?>  
    </section>
<?php
  }
?>  
  </main>
  
</body>
</html>