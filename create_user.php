<?php
require_once 'mysql_conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']); 
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL); 
    $password = trim($_POST['password']);

    $pdo = getDbConnection();

    // Перевіряємо, чи такий email вже існує
    $checkStmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $checkStmt->execute([$email]);
    if ($checkStmt->fetch()) {
        echo "❌ Користувач з такою електронною поштою вже зареєстрований.";
        exit;
    }

    $open_password = $password;


    $password_hash = password_hash($password, PASSWORD_BCRYPT);


    // Зберігаємо у базу
    $stmt = $pdo->prepare("INSERT INTO users (name, email, open_password, password_hash) VALUES (?, ?, ?, ?)");
    $stmt->execute([$name, $email, $open_password, $password_hash]);
    

    echo "✅ Користувача успішно зареєстровано!";
}
?>
