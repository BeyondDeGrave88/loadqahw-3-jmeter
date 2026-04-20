<?php
  require $_SERVER['DOCUMENT_ROOT'] . '/config/autoloader.php';
  session_start();
  $user = new User($_SESSION);
  if (!isset($_SESSION['database'])) {
    $_SESSION['database'] = new Database();
  }
  // Отчистим сессию от данных которые могли остаться от работы клиентской части сайта
  if (isset($_SESSION['halls'])) {unset($_SESSION['halls']);}
  if (isset($_SESSION['films'])) {unset($_SESSION['halls']);}
  if (isset($_SESSION['seances'])) {unset($_SESSION['halls']);}
  if (isset($_SESSION['sales'])) {unset($_SESSION['halls']);}
?>

<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>ИдёмВКино</title>
  <link rel="stylesheet" href="CSS/normalize.css">
  <link rel="stylesheet" href="CSS/styles.css">
  <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900&amp;subset=cyrillic,cyrillic-ext,latin-ext" rel="stylesheet">
</head>

<body>
  <?php 
    if (!$user->isLogged()) {
      include 'login.html';
      exit;
    }
  ?>
  <header class="page-header">
    <h1 class="page-header__title">Идём<span>в</span>кино</h1>
    <span class="page-header__subtitle">Администраторррская</span>
  </header>
  
  <main class="conf-steps">
    <section class="conf-step" id="hall-control" style="display: none">
      <header class="conf-step__header conf-step__header_opened">
        <h2 class="conf-step__title">Управление залами</h2>
      </header>
      <div class="conf-step__wrapper">
        <p class="conf-step__paragraph">Доступные залы:</p>
        <ul class="conf-step__list"></ul>
        <a href=""><button class="conf-step__button conf-step__button-accent button__add-hall">Создать зал</button></a>
      </div>
    </section>
    
    <section class="conf-step" id="hall-configuration" style="display: none">
      <header class="conf-step__header conf-step__header_opened">
        <h2 class="conf-step__title">Конфигурация залов</h2>
      </header>
      <div class="conf-step__wrapper">
        <p class="conf-step__paragraph">Выберите зал для конфигурации:</p>
        <ul class="conf-step__selectors-box"></ul>
        <p class="conf-step__paragraph">Укажите количество рядов и максимальное количество кресел в ряду:</p>
        <div class="conf-step__legend">
          <label class="conf-step__label">Рядов, шт<input id="input_rows_count" type="text" class="conf-step__input"></label>
          <span class="multiplier">x</span>
          <label class="conf-step__label">Мест, шт<input id="input_places_count" type="text" class="conf-step__input"></label>
        </div>
        <p class="conf-step__paragraph">Теперь вы можете указать типы кресел на схеме зала:</p>
        <div class="conf-step__legend">
          <span class="conf-step__chair conf-step__chair_standart"></span> — обычные кресла
          <span class="conf-step__chair conf-step__chair_vip"></span> — VIP кресла
          <span class="conf-step__chair conf-step__chair_disabled"></span> — заблокированные (нет кресла)
          <p class="conf-step__hint">Чтобы изменить вид кресла, нажмите по нему левой кнопкой мыши</p>
        </div>  
        
        <div class="conf-step__hall">
          <div class="conf-step__hall-wrapper"></div>
          <div class="conf-step__wrapper__save-status"></div>    
        </div>
        
        <fieldset class="conf-step__buttons text-center">
          <button class="conf-step__button conf-step__button-regular" disabled>Отмена</button>
          <input type="submit" value="Сохранить" class="conf-step__button conf-step__button-accent">
        </fieldset>                 
      </div>
    </section>
    
    <section class="conf-step" id="price-configuration" style="display: none">
      <header class="conf-step__header conf-step__header_opened">
        <h2 class="conf-step__title">Конфигурация цен</h2>
      </header>
      <div class="conf-step__wrapper">
        <p class="conf-step__paragraph">Выберите зал для конфигурации:</p>
        <ul class="conf-step__selectors-box"></ul>
          
        <p class="conf-step__paragraph">Установите цены для типов кресел:</p>
          <div class="conf-step__legend">
            <label class="conf-step__label">Цена, рублей<input type="text" class="conf-step__input"  id="input_price_standart"></label>
            за <span class="conf-step__chair conf-step__chair_standart"></span> обычные кресла
          </div>  
          <div class="conf-step__legend">
            <label class="conf-step__label">Цена, рублей<input type="text" class="conf-step__input"  id="input_price_vip"></label>
            за <span class="conf-step__chair conf-step__chair_vip"></span> VIP кресла
          </div>
          <div class="conf-step__wrapper__save-status"></div>  
        
        <fieldset class="conf-step__buttons text-center">
          <button class="conf-step__button conf-step__button-regular" disabled>Отмена</button>
          <input type="submit" value="Сохранить" class="conf-step__button conf-step__button-accent">
        </fieldset>  
      </div>
    </section>
    
    <section class="conf-step" id="grid-session" style="display: none">
      <header class="conf-step__header conf-step__header_opened">
        <h2 class="conf-step__title">Сетка сеансов</h2>
      </header>
      <div class="conf-step__wrapper">
        <p class="conf-step__paragraph">
          <a href=""><button class="conf-step__button conf-step__button-accent button__add-movie">Добавить фильм</button></a>
        </p>
        <div class="conf-step__movies"></div>
        
        <div class="conf-step__seances"></div>
        
      <!--  <fieldset class="conf-step__buttons text-center">
          <button class="conf-step__button conf-step__button-regular">Отмена</button>
          <input type="submit" value="Сохранить" class="conf-step__button conf-step__button-accent">
        </fieldset>  -->
      </div>
    </section>
    
    <section class="conf-step" id="start-sales" style="display: none">
      <header class="conf-step__header conf-step__header_opened">
        <h2 class="conf-step__title">Открыть продажи</h2>
      </header>
      <div class="conf-step__wrapper">
        <p class="conf-step__paragraph">Выбирите залл для открытия/закрытия продаж:</p>
        <ul class="conf-step__selectors-box"></ul>
      </div>
      <div class="conf-step__wrapper text-center">
        <p class="conf-step__paragraph" style="font-weight: 700"></p>
        <button class="conf-step__button conf-step__button-accent">Открыть продажу билетов</button>
      </div>
    </section>
  </main>


  <script src="js/createRequest.js"></script>
  <script src="js/classes/Dom.js"></script>
  <script src="js/main.js"></script>
  <script src="js/popup.js"></script>
  <script src="js/accordeon.js"></script>
  <script src="js/1_hallControl.js"></script>
  <script src="js/2_hallConfiguration.js"></script>
  <script src="js/3_priceConfiguration.js"></script>
  <script src="js/4_gridSession.js"></script>
  <script src="js/5_startSales.js"></script>

</body>
</html>