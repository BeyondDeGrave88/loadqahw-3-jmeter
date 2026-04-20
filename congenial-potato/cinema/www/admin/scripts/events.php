<?php

    // Отчистим сессию от данных которые могли остаться от работы клиентской части сайта
    if (isset($_SESSION['halls'])) {unset($_SESSION['halls']);}
    if (isset($_SESSION['films'])) {unset($_SESSION['halls']);}
    if (isset($_SESSION['seances'])) {unset($_SESSION['halls']);}
    if (isset($_SESSION['sales'])) {unset($_SESSION['halls']);}
    // Разметка стандартной конфигурации зала (10х10)
    const HALL_CONFIGURATION_STANDART = '<div class="conf-step__row"><span class="conf-step__chair conf-step__chair_standart"></span><span class="conf-step__chair conf-step__chair_standart"></span><span class="conf-step__chair conf-step__chair_standart"></span><span class="conf-step__chair conf-step__chair_standart"></span><span class="conf-step__chair conf-step__chair_standart"></span><span class="conf-step__chair conf-step__chair_standart"></span><span class="conf-step__chair conf-step__chair_standart"></span><span class="conf-step__chair conf-step__chair_standart"></span><span class="conf-step__chair conf-step__chair_standart"></span><span class="conf-step__chair conf-step__chair_standart"></span></div><div class="conf-step__row"><span class="conf-step__chair conf-step__chair_standart"></span><span class="conf-step__chair conf-step__chair_standart"></span><span class="conf-step__chair conf-step__chair_standart"></span><span class="conf-step__chair conf-step__chair_standart"></span><span class="conf-step__chair conf-step__chair_standart"></span><span class="conf-step__chair conf-step__chair_standart"></span><span class="conf-step__chair conf-step__chair_standart"></span><span class="conf-step__chair conf-step__chair_standart"></span><span class="conf-step__chair conf-step__chair_standart"></span><span class="conf-step__chair conf-step__chair_standart"></span></div><div class="conf-step__row"><span class="conf-step__chair conf-step__chair_standart"></span><span class="conf-step__chair conf-step__chair_standart"></span><span class="conf-step__chair conf-step__chair_standart"></span><span class="conf-step__chair conf-step__chair_standart"></span><span class="conf-step__chair conf-step__chair_standart"></span><span class="conf-step__chair conf-step__chair_standart"></span><span class="conf-step__chair conf-step__chair_standart"></span><span class="conf-step__chair conf-step__chair_standart"></span><span class="conf-step__chair conf-step__chair_standart"></span><span class="conf-step__chair conf-step__chair_standart"></span></div><div class="conf-step__row"><span class="conf-step__chair conf-step__chair_standart"></span><span class="conf-step__chair conf-step__chair_standart"></span><span class="conf-step__chair conf-step__chair_standart"></span><span class="conf-step__chair conf-step__chair_standart"></span><span class="conf-step__chair conf-step__chair_standart"></span><span class="conf-step__chair conf-step__chair_standart"></span><span class="conf-step__chair conf-step__chair_standart"></span><span class="conf-step__chair conf-step__chair_standart"></span><span class="conf-step__chair conf-step__chair_standart"></span><span class="conf-step__chair conf-step__chair_standart"></span></div><div class="conf-step__row"><span class="conf-step__chair conf-step__chair_standart"></span><span class="conf-step__chair conf-step__chair_standart"></span><span class="conf-step__chair conf-step__chair_standart"></span><span class="conf-step__chair conf-step__chair_standart"></span><span class="conf-step__chair conf-step__chair_standart"></span><span class="conf-step__chair conf-step__chair_standart"></span><span class="conf-step__chair conf-step__chair_standart"></span><span class="conf-step__chair conf-step__chair_standart"></span><span class="conf-step__chair conf-step__chair_standart"></span><span class="conf-step__chair conf-step__chair_standart"></span></div><div class="conf-step__row"><span class="conf-step__chair conf-step__chair_standart"></span><span class="conf-step__chair conf-step__chair_standart"></span><span class="conf-step__chair conf-step__chair_standart"></span><span class="conf-step__chair conf-step__chair_standart"></span><span class="conf-step__chair conf-step__chair_standart"></span><span class="conf-step__chair conf-step__chair_standart"></span><span class="conf-step__chair conf-step__chair_standart"></span><span class="conf-step__chair conf-step__chair_standart"></span><span class="conf-step__chair conf-step__chair_standart"></span><span class="conf-step__chair conf-step__chair_standart"></span></div><div class="conf-step__row"><span class="conf-step__chair conf-step__chair_standart"></span><span class="conf-step__chair conf-step__chair_standart"></span><span class="conf-step__chair conf-step__chair_standart"></span><span class="conf-step__chair conf-step__chair_standart"></span><span class="conf-step__chair conf-step__chair_standart"></span><span class="conf-step__chair conf-step__chair_standart"></span><span class="conf-step__chair conf-step__chair_standart"></span><span class="conf-step__chair conf-step__chair_standart"></span><span class="conf-step__chair conf-step__chair_standart"></span><span class="conf-step__chair conf-step__chair_standart"></span></div><div class="conf-step__row"><span class="conf-step__chair conf-step__chair_standart"></span><span class="conf-step__chair conf-step__chair_standart"></span><span class="conf-step__chair conf-step__chair_standart"></span><span class="conf-step__chair conf-step__chair_standart"></span><span class="conf-step__chair conf-step__chair_standart"></span><span class="conf-step__chair conf-step__chair_standart"></span><span class="conf-step__chair conf-step__chair_standart"></span><span class="conf-step__chair conf-step__chair_standart"></span><span class="conf-step__chair conf-step__chair_standart"></span><span class="conf-step__chair conf-step__chair_standart"></span></div><div class="conf-step__row"><span class="conf-step__chair conf-step__chair_standart"></span><span class="conf-step__chair conf-step__chair_standart"></span><span class="conf-step__chair conf-step__chair_standart"></span><span class="conf-step__chair conf-step__chair_standart"></span><span class="conf-step__chair conf-step__chair_standart"></span><span class="conf-step__chair conf-step__chair_standart"></span><span class="conf-step__chair conf-step__chair_standart"></span><span class="conf-step__chair conf-step__chair_standart"></span><span class="conf-step__chair conf-step__chair_standart"></span><span class="conf-step__chair conf-step__chair_standart"></span></div><div class="conf-step__row"><span class="conf-step__chair conf-step__chair_standart"></span><span class="conf-step__chair conf-step__chair_standart"></span><span class="conf-step__chair conf-step__chair_standart"></span><span class="conf-step__chair conf-step__chair_standart"></span><span class="conf-step__chair conf-step__chair_standart"></span><span class="conf-step__chair conf-step__chair_standart"></span><span class="conf-step__chair conf-step__chair_standart"></span><span class="conf-step__chair conf-step__chair_standart"></span><span class="conf-step__chair conf-step__chair_standart"></span><span class="conf-step__chair conf-step__chair_standart"></span></div><div class="conf-step__hall-wrapper__save-status"></div>';



    require $_SERVER['DOCUMENT_ROOT'] . '/config/autoloader.php';
    session_start();

    if (!isset($_POST['event'])) {exit;}

    // Добавить зал
    if ($_POST['event'] == "hall_add") {
        $query = "INSERT INTO `" . DB_NAME . "`.`halls` (`hall_id`, `hall_name`, `hall_rows`, `hall_places`, `hall_config`, `hall_price_standart`, `hall_price_vip`, `hall_open`) VALUES (null, '";
        $query .= $_POST['hallName']  . "', '10', '10', '" . HALL_CONFIGURATION_STANDART ."', '100', '350', '0');";
        $response = array($_SESSION['database']->mysqlQuery($query));
        // Если ошибки нет получаем обновленный список заллов
        if (!$response[0]["err"]) {
            $response = array(
                "halls" => $_SESSION['database']->updateHalls()
            );
        };
        echo json_encode($response);
    }

    // Удалить зал
    if ($_POST['event'] == "hall_del") {
        $query = "DELETE FROM `" . DB_NAME . "`.`halls` WHERE `halls`.`hall_id`=" . $_POST['hallId'];
        $response = array($_SESSION['database']->mysqlQuery($query));
        // Если ошибки нет получаем обновленный список заллов и сеансов
        if (!$response[0]["err"]) {
            $response = array(
                "halls" => $_SESSION['database']->updateHalls(),
                "seances" => $_SESSION['database']->updateSeances()
            );
        };
        echo json_encode($response);    
    }


    // Сохранить изменения в конфигурации зала
    if ($_POST['event'] == "hall_configuration_save") {
        $query = "UPDATE `" . DB_NAME . "`.`halls` ";
        $query .= "SET `hall_rows` = '" . $_POST['hallRows'] . "', `hall_places` = '" . $_POST['hallPlaces'] . "', `hall_config` = '" . $_POST['hallConfig'] . "' ";
        $query .= "WHERE `halls`.`hall_id` =" . $_POST['hallId'];
        $response = array($_SESSION['database']->mysqlQuery($query));
        echo json_encode($response);
    }


    // Сохранить изменения в конфигурации цен
    if ($_POST['event'] == "price_configuration_save") {
        $query = "UPDATE `" . DB_NAME . "`.`halls` ";
        $query .= "SET `hall_price_standart` = '" . $_POST['priceStandart'] . "', `hall_price_vip` = '" . $_POST['priceVip']  . "' ";
        $query .= "WHERE `halls`.`hall_id` =" . $_POST['hallId'];
        $response = array($_SESSION['database']->mysqlQuery($query));
        echo json_encode($response);
    }

    // Открыть/Закрыть зал для продаж
    if ($_POST['event'] == "hall_open") {
        $query = "UPDATE `" . DB_NAME . "`.`halls` ";
        $query .= "SET `hall_open` = '" . $_POST['hallStatus'] . "' ";
        $query .= "WHERE `halls`.`hall_id` =" . $_POST['hallId'];
        $response = array($_SESSION['database']->mysqlQuery($query));
        // Если ошибки нет получаем обновленный список залов
        if (!$response[0]["err"]) {
            $response = array(
                "halls" => $_SESSION['database']->updateHalls()
            );
        };
        echo json_encode($response); 
    }

//-----------------------------------------------------------------------------

    // Добавить фильм
    if ($_POST['event'] == "film_add") {

        $query = "INSERT INTO `" . DB_NAME . "`.`films` (`film_id`, `film_name`, `film_duration`, `film_description`, `film_origin`) VALUES (null, '";
        $query .= $_POST['filmName']  . "', '" . $_POST['filmDuratione'] . "', '" . $_POST['filmDescription'] . "', '" . $_POST['filmOrigin'] . "');";
        $response = array($_SESSION['database']->mysqlQuery($query));

        // Если ошибки нет то:
        if (!$response[0]["err"]) {
            // загружаем файл с картинкой постера
               /* Заеняем в строке все пробелы на символ "+" (потому что при кодировании строки в js для передачи в качестве POST запроса почему-то все символы "+" заменились пробелами.);  
                Обрезаем начало строки "data:image/jpeg(или png);base64,"; 
                Декодируем строку из base64*/
            $contentPoster = base64_decode(str_replace(' ', '+', substr($_POST['filmPoster'], strpos($_POST['filmPoster'], ',')+1)));
                // Получаем ID только что добавленного фильма 
            $query = "SELECT MAX(film_id) film_id FROM films";
            $response = $_SESSION['database']->mysqlQuery($query);
            $file = fopen($_SERVER['DOCUMENT_ROOT'] . "/img/posters/" . $response['result'][0]['film_id'] . '.png', "wb");
            fwrite($file, $contentPoster);
            fclose($file);
            // Получаем обновленный список фильмов
            $query = "SELECT * FROM films";
            $response = array(
                "films" => $_SESSION['database']->updateFilms()
            );
        }
        echo json_encode($response);
    }

    // Удалить фильма
    if ($_POST['event'] == "film_del") {
        $query = "DELETE FROM `" . DB_NAME . "`.`films` WHERE `films`.`film_id`=" . $_POST['filmId'];
        $response = array($_SESSION['database']->mysqlQuery($query));
        // Если ошибки нет получаем обновленный список заллов
        if (!$response[0]["err"]) {
            // Удаляем файл с постером
            unlink($_SERVER['DOCUMENT_ROOT'] . "/img/posters/" . $_POST['filmId'] . '.png');
            // Обновление списка фильмов и сеансов
            $response = array(
                "films" => $_SESSION['database']->updateFilms(),
                "seances" => $_SESSION['database']->updateSeances()
            );
        }
        echo json_encode($response);    
    }

//-------------------------------------------------------------------------------------------------

    // Добавить сеанс
    if ($_POST['event'] == "seance_add") {
        $start = (strtotime($_POST['time']) - strtotime('today'))/60; // Начало сеанса мин от начала суток
        $end = $start + $_POST['filmDuration']; // конец сеанса
        $query = "INSERT INTO `" . DB_NAME . "`.`seances` (`seance_id`, `seance_hallid`, `seance_filmid`, `seance_time`, `seance_start`, `seance_end`) VALUES (null, '";
        $query .= $_POST['hallId']  . "', '" . $_POST['filmId'] . "', '" . $_POST['time'] . "', '" . $start . "', '" . $end . "');";
        $response = array($_SESSION['database']->mysqlQuery($query));
        // Если ошибки нет получаем обновленный список сеансов
        if (!$response[0]["err"]) {
            $response = array(
                "seances" => $_SESSION['database']->updateSeances()
            );
        }
        echo json_encode($response);
    }

    // Удалить сеанс
    if ($_POST['event'] == "seance_del") {
        $query = "DELETE FROM " . DB_NAME . ".seances WHERE seances.seance_id=" . $_POST['seanceId'];
        $response = array($_SESSION['database']->mysqlQuery($query));
        // Если ошибки нет получаем обновленный список сеансов
        if (!$response[0]["err"]) {
            $response = array(
                "seances" => $_SESSION['database']->updateSeances()
            );
        }
        echo json_encode($response);
    } 

//===========================================================================

    /*// Получение списка залов
    if ($_POST['event'] == "getHalls") {
        $query = "SELECT * FROM halls";
        $response = $_SESSION['database']->mysqlQuery($query);
        echo json_encode($response);
    }

    // Получение списка фильмов
    if ($_POST['event'] == "getFilms") {
        $query = "SELECT * FROM films";
        $response = $_SESSION['database']->mysqlQuery($query);
        echo json_encode($response);
    }

    // Получение списка сеансов 
    if ($_POST['event'] == "getSeances") {
        $query = "SELECT * FROM seances";
        $response = $_SESSION['database']->mysqlQuery($query);
        echo json_encode($response);
    }*/

    if ($_POST['event'] == "update") {
        $response = array(
            "halls" => $_SESSION['database']->updateHalls(),
            "films" => $_SESSION['database']->updateFilms(),
            "seances" => $_SESSION['database']->updateSeances()
        );
        echo json_encode($response);
    }

//==============================================


?>