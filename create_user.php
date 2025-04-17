<?php

require_once 'mysql_conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']); 
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL); 
    $password = trim($_POST['password']);
    $phone = preg_replace('/\D/', '', $_POST['phone']); // лише цифри

    // Перевірка формату номера
    if (!preg_match('/^380\d{9}$/', $phone)) {
        echo "❌ Невірний формат номера телефону. Використовуйте формат 380XXXXXXXXX";
        exit;
    }

    $pdo = getDbConnection();

    $checkStmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $checkStmt->execute([$email]);
    if ($checkStmt->fetch()) {
        echo "❌ Користувач з такою електронною поштою вже зареєстрований.";
        exit;
    }

    $open_password = $password;
    $password_hash = password_hash($password, PASSWORD_BCRYPT);

    $stmt = $pdo->prepare("INSERT INTO users (name, email, open_password, password_hash, phone) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$name, $email,$open_password, $password_hash,$phone]);

    echo "✅ Користувача успішно зареєстровано!";
}
?>
