<?php
require_once 'mysql_conn.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['email']) && !empty($_POST['password'])) {
        $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
        $password = trim($_POST['password']);

        $pdo = getDbConnection();
        $stmt = $pdo->prepare("SELECT password_encrypted FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && isset($user['password_encrypted'])) {
            $config = include('config.php');
            $encryption_key = $config['encryption_key'];

            // Декодуємо base64
            $encrypted_data = base64_decode($user['password_encrypted']);

            // Витягуємо IV (перші 16 байт)
            $iv = substr($encrypted_data, 0, 16);

            // Витягуємо зашифрований текст (решта)
            $ciphertext = substr($encrypted_data, 16);

            // Розшифровуємо
            $decrypted_password = openssl_decrypt($ciphertext, 'aes-256-cbc', $encryption_key, 0, $iv);

            if ($decrypted_password === $password) {
                
                echo "✅ Успішний вхід (Encrypted Password)";
                echo "✅ Pass send by client: <b>$password</b><br>";
                echo "✅ Pass received by server: <b>$password</b><br>";
                echo "✅ Pass stored in DB (encrypted): <b>{$user['password_encrypted']}</b><br>";
                echo "✅ Pass after decrypting: <b>$decrypted_password</b>";
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
