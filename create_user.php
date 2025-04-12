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

    // Зберігаємо відкритий пароль
    $open_password = $password;

    // Генеруємо хеш пароля
    $password_hash = password_hash($password, PASSWORD_BCRYPT);

    // Шифруємо пароль
    $config = include('config.php');
    $encryption_key = $config['encryption_key'];
    $iv = openssl_random_pseudo_bytes(16); 
    $encrypted = openssl_encrypt($password, 'aes-256-cbc', $encryption_key, 0, $iv);
    $password_encrypted = base64_encode($iv . $encrypted);

    // Зберігаємо у базу
    $stmt = $pdo->prepare("INSERT INTO users (name, email, open_password, password_hash, password_encrypted) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$name, $email, $open_password, $password_hash, $password_encrypted]);

    echo "✅ Користувача успішно зареєстровано!";
}
?>
