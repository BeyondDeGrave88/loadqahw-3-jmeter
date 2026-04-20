<?php

$hallAdd =
'<div class="popup active">
<div class="popup__container">
  <div class="popup__content">
    <div class="popup__header">
      <h2 class="popup__title">
        Добавление зала
        <a class="popup__dismiss" href="#"><img src="i/close.png" alt="Закрыть"></a>
      </h2>

    </div>
    <div class="popup__wrapper">
      <form action="add_hall" method="post" accept-charset="utf-8">
        <label class="conf-step__label conf-step__label-fullsize" for="name">
          Название зала
          <input class="conf-step__input" type="text" placeholder="Например, &laquo;Зал 1&raquo;" name="name" required>
        </label>
        <div class="conf-step__buttons text-center">
          <input type="submit" value="Добавить зал" class="conf-step__button conf-step__button-accent" data-event="hall_add">
          <button class="conf-step__button conf-step__button-regular" type="button">Отменить</button>            
        </div>
      </form>
    </div>
  </div>
</div>
</div>';

// Передаем ID удаляемого залла
$hallId = (isset($_GET['hall_id'])) ? ' data-hall-id="' . $_GET['hall_id'] . '"' : "";
$hallName = (isset($_GET['hall_name'])) ? '"<b>' . $_GET['hall_name'] . '</b>"' : '';
$hallDelete =
'<div class="popup active">
<div class="popup__container">
  <div class="popup__content">
    <div class="popup__header">
      <h2 class="popup__title">
        Удаление зала
        <a class="popup__dismiss" href="#"><img src="i/close.png" alt="Закрыть"></a>
      </h2>

    </div>
    <div class="popup__wrapper">
      <form action="delete_hall" method="post" accept-charset="utf-8">
        <p class="conf-step__paragraph">Вы действительно хотите удалить зал <span>' . $hallName . '</span>?</p>
        <!-- В span будет подставляться название зала -->
        <div class="conf-step__buttons text-center">
          <input type="submit" value="Удалить" class="conf-step__button conf-step__button-accent" data-event="hall_del"' . $hallId  . '>
          <button class="conf-step__button conf-step__button-regular" type="button">Отменить</button>            
        </div>
      </form>
    </div>
  </div>
</div>
</div>';

$filmAdd = 
'<div class="popup active">
<div class="popup__container">
  <div class="popup__content">
    <div class="popup__header">
      <h2 class="popup__title">
        Добавление фильма
        <a class="popup__dismiss" href="#"><img src="i/close.png" alt="Закрыть"></a>
      </h2>

    </div>
    <div class="popup__wrapper">
      <form action="add_movie" method="post" accept-charset="utf-8">
        <div class="popup__container">
          <div class="popup__poster"></div>
          <div class="popup__form">
            <label class="conf-step__label conf-step__label-fullsize" for="name">
              Название фильма
              <input class="conf-step__input" type="text" placeholder="Например, &laquo;Гражданин Кейн&raquo;" name="name" required>
            </label>
            <label class="conf-step__label conf-step__label-fullsize" for="name">
              Продолжительность фильма (мин.)
              <input class="conf-step__input" type="text"  name="duration" data-last-value="" required>
            </label>
            <label class="conf-step__label conf-step__label-fullsize" for="name">
              Описание фильма
              <textarea class="conf-step__input" type="text" name="description"  required></textarea>
            </label>
            <label class="conf-step__label conf-step__label-fullsize" for="name">
              Страна
              <input class="conf-step__input" type="text"  name="duration" data-last-value="" required>
            </label>
          </div>
        </div>
        <div class="conf-step__buttons text-center">
          <input type="submit" value="Добавить фильм" class="conf-step__button conf-step__button-accent" data-event="film_add">
          <input type="submit" value="Загрузить постер" class="conf-step__button conf-step__button-accent">
          <button class="conf-step__button conf-step__button-regular" type="button">Отменить</button>            
        </div>
      </form>
    </div>
  </div>
</div>
</div>';

// Передаем ID удаляемого фильма
$filmId = (isset($_GET['film_id'])) ? ' data-film-id="' . $_GET['film_id'] . '"' : '';
$filmName = (isset($_GET['film_name'])) ? '"<b>' . $_GET['film_name'] . '</b>"' : '';
$filmDelete =
'<div class="popup active">
<div class="popup__container">
  <div class="popup__content">
    <div class="popup__header">
      <h2 class="popup__title">
        Удаление фильма
        <a class="popup__dismiss" href="#"><img src="i/close.png" alt="Закрыть"></a>
      </h2>

    </div>
    <div class="popup__wrapper">
      <form action="delete_hall" method="post" accept-charset="utf-8">
        <p class="conf-step__paragraph">Вы действительно хотите удалить фильм <span> ' . $filmName . '</span>?</p>
        <!-- В span будет подставляться название фильма -->
        <div class="conf-step__buttons text-center">
          <input type="submit" value="Удалить" class="conf-step__button conf-step__button-accent" data-event="film_del"' . $filmId  . '>
          <button class="conf-step__button conf-step__button-regular" type="button">Отменить</button>            
        </div>
      </form>
    </div>
  </div>
</div>
</div>';

// Передаем ID фильма и залла 
$filmId = (isset($_GET['film_id'])) ? ' data-film-id="' . $_GET['film_id'] . '"' : '';
$hallId = (isset($_GET['hall_id'])) ? ' data-hall-id="' . $_GET['hall_id'] . '"' : "";
$showtimeAdd = 
'<div class="popup active"' . $filmId  . $hallId . '>
<div class="popup__container">
  <div class="popup__content">
    <div class="popup__header">
      <h2 class="popup__title">
        Добавление сеанса
        <a class="popup__dismiss" href="#"><img src="i/close.png" alt="Закрыть"></a>
      </h2>

    </div>
    <div class="popup__wrapper">
      <form action="add_movie" method="post" accept-charset="utf-8">
        <label class="conf-step__label conf-step__label-fullsize" for="hall">
          Название зала
          <select class="conf-step__input" name="hall" required>
          </select>
        </label>
        <label class="conf-step__label conf-step__label-fullsize" for="hall">
          Название фильма
          <select class="conf-step__input" name="film" required>
          </select>
        </label>
        <label class="conf-step__label conf-step__label-fullsize" for="name">
          Время начала
          <input class="conf-step__input" type="time" value="00:00" name="start_time" required>
        </label>

        <div class="conf-step__buttons text-center">
          <input type="submit" value="Добавить" class="conf-step__button conf-step__button-accent" data-event="seance_add">
          <button class="conf-step__button conf-step__button-regular" type="button">Отменить</button>            
        </div>
      </form>
    </div>
  </div>
</div>
</div>';


$seanceId = (isset($_GET['seance_id'])) ? ' data-seance-id="' . $_GET['seance_id'] . '"' : '';
$filmName = (isset($_GET['film_name'])) ? '"<b>' . $_GET['film_name'] . '</b>"' : '';
$showtimeDelete =
'<div class="popup active">
<div class="popup__container">
  <div class="popup__content">
    <div class="popup__header">
      <h2 class="popup__title">
        Снятие с сеанса
        <a class="popup__dismiss" href="#"><img src="i/close.png" alt="Закрыть"></a>
      </h2>

    </div>
    <div class="popup__wrapper">
      <form action="delete_hall" method="post" accept-charset="utf-8">
        <p class="conf-step__paragraph">Вы действительно хотите снять с сеанса фильм <span>' . $filmName . '</span>?</p> .
        <div class="conf-step__buttons text-center">
          <input type="submit" value="Удалить" class="conf-step__button conf-step__button-accent" data-event="seance_del"' . $seanceId . '>
          <button class="conf-step__button conf-step__button-regular" type="button">Отменить</button>            
        </div>
      </form>
    </div>
  </div>
</div>
</div>';

if (isset($_GET['popupname'])) {
  $result = array(
    "result" => "",
    "err" => 0,
    "errMessage" => ""
  );

  if ($_GET['popupname'] == 'hallDelete') {$result["result"] = $hallDelete;}; // Удаление залла
  if ($_GET['popupname'] == 'hallAdd') {$result["result"] = $hallAdd;};  // Добавление залла
  if ($_GET['popupname'] == 'filmDelete') {$result["result"] = $filmDelete;}; // Удаление фильма
  if ($_GET['popupname'] == 'filmAdd') {$result["result"] = $filmAdd;};  // Добавление фильма  
  if ($_GET['popupname'] == 'showtimeAdd') {$result["result"] = $showtimeAdd;};  // Добавить сеанс
  if ($_GET['popupname'] == 'showtimeDelete') {$result["result"] = $showtimeDelete;};  // Удалить сеанс

  $response = array("popup" => $result);
  echo json_encode($response);
};

?>