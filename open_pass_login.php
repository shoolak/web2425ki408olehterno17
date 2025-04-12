<?php
require_once 'mysql_conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['email']) && !empty($_POST['password'])) {
        $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
        $password = trim($_POST['password']);

        $pdo = getDbConnection();

        $stmt = $pdo->prepare("SELECT open_password FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && isset($user['open_password'])) {
            if ($user['open_password'] === $password) {
                echo "✅ Успішний вхід (Open Password)";
            } else {
                echo "❌ Невірний логін або пароль.";
            }
        } else {
            echo "❌ Користувача не знайдено.";
        }
    } else {
        echo "⚠️ Будь ласка, заповніть всі поля.";
    }
}
?>
