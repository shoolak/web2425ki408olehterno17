<?php
require_once 'mysql_conn.php';
session_start();

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
                echo "✅ Pass send by client: <b>$password</b><br>";
                echo "✅ Pass received by server: <b>$password</b><br>";
                echo "✅ Pass stored in DB: <b>{$user['open_password']}</b>";
                $_SESSION['user'] = [
                    'email' => $email
                ];
                echo "<script>
                setTimeout(function() {
                    window.location.href = 'index.php';
                }, 3000);
            </script>";
            exit;
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
