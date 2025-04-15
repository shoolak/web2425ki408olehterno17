<?php

function getDbConnection() {
    if ($_SERVER['SERVER_NAME'] == 'localhost') {
        $servername = "localhost";
        $username = "root";
        $password = ""; 
        $dbname = "test"; 
    } else {
        $config = include('config.php');
        $servername = $config['servername'];
        $username = $config['username'];
        $password = $config['password'];
        $dbname = $config['dbname']; 
    }

    try {
        $dsn = "mysql:host=$servername;dbname=$dbname;charset=utf8";
        $pdo = new PDO($dsn, $username, $password);
        
        // Встановлюємо режим обробки помилок
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $pdo;
    } catch (PDOException $e) {
        die("Підключення не вдалося: " . $e->getMessage());
    }
}
?>
