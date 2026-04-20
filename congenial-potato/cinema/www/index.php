<?php
    require 'config/autoloader.php';
    session_start();
    $_SESSION['database'] = new Database();
    header("Location: /client/index.php");

?>

<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>ИдёмВКино</title>
        <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900&amp;subset=cyrillic,cyrillic-ext,latin-ext" rel="stylesheet">
    </head>
    <body>
        <?php
           /* if ($user->isLogged()) {
                include 'admin/index.php';
            } else {
                include 'admin/index.php';
            }*/
            //include 'client/index.php';
            
        ?>
    </body>
</html>




<!--   require 'config/autoloader.php';



   require_once("include/database.php");

    $query = "SELECT * FROM users";
    $result = mysqli_query($linkDB, $query);

    $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
    print_r($data); -->
