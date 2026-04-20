<?php
    require $_SERVER['DOCUMENT_ROOT'] . '/config/autoloader.php';
    session_start();
    const COOKIE_LIFE_TIME = 86400;
    if (!isset($_SESSION['database'])) {
        $_SESSION['database'] = new Database();
    }
    if ((isset($_POST['email'])) && (isset($_POST['password']))) {
        $query = "SELECT * FROM users WHERE `user_email`=" ."'" . $_POST['email'] . "'" . " AND `user_password`=" . "'" . $_POST['password'] . "'";
        $response = array($_SESSION['database']->mysqlQuery($query));
        if (count($response[0]['result'])) {
            $_SESSION['email'] = $_POST['email'];
            setcookie('email', $_POST['email'], time() + COOKIE_LIFE_TIME);
            header('Location: ../index.php');
        } else  {
            echo "Ошибка авторизации!";
        }
    }
?>