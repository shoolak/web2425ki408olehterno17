<?php
require_once 'mysql_conn.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['email']) && !empty($_POST['password'])) {
        $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
        $password = trim($_POST['password']);

        $pdo = getDbConnection();
        $stmt = $pdo->prepare("SELECT password_hash FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Виправлена перевірка (було $user['password'], а має бути введений пароль)
        if ($user && password_verify($password, $user['password_hash'])) {
            $_SESSION['user'] = [
                'email' => $email
            ];
            echo "✅ Успішний вхід (Hash Password)";
            echo "✅ Pass send by client: <b>$password</b><br>";
            echo "✅ Pass received by server: <b>$password</b><br>";
            echo "✅ Pass stored in DB (hash): <b>{$user['password_hash']}</b>";
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
        echo "⚠️ Будь ласка, заповніть всі поля.";
    }
}
?>
