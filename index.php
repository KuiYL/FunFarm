<?php
    ob_start();
    session_start();
    include('php/connect.php');

    $page = isset($_GET['page']) ? $_GET['page'] : 'main';

    function includePage($page)
    {
        $filePath = 'pages/' . $page . '.php';
        if(file_exists($filePath)){
            include($filePath);
        }
        else{
            echo "<h1>Страница не найдена</h1>";
        }
    }
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Весёлая ферма</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/media.css">
    <script src="js/app.js" defer></script>
</head>

<body>
    <?php include('includes/header.php') ?>

    <?php
    switch($page) {
        case 'main':
            includePage('main');
            break;

        case 'register':
            includePage('register');
            break;
        
        case 'login':
            includePage('login');
            break;

        case 'profile':
            includePage('profile');
            break;

        case 'users':
            includePage('users');
            break;

        case 'edit':
            includePage('edit');
            break;

        case 'update':
            includePage('update');
            break;
            
        default:
            echo "<div class='forms content py'><h1>404 - Страница не найдена</h1></div>";
            break;
    }
    ?>

    <?php 
        include('includes/footer.php');
        ob_end_flush(); 
    ?>
</body>

</html>