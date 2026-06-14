<?php 
    try{
        $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, //вывод исключений при ошибках
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, //вовзарщение массива по умолчанию
    ];
    $dsn = "mysql:host=localhost;dbname=funFarm";
    $db_user = "root";
    $db_pass = "";
    $connect = new PDO($dsn, $db_user, $db_pass, $options);
}catch(PDOException $error){
    die("Ошибка подключения к БД: " . $error->getMessage());
}
?>