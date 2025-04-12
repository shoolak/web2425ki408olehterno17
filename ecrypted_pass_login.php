<?php
require_once 'mysql_conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['email']) && !empty($_POST['password'])) {
        $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
        $password = trim($_POST['password']);

        $pdo = getDbConnection();
        $stmt = $pdo->prepare("SELECT password_encrypted FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && isset($user['password_encrypted'])) {
            $encryption_key = "my-secret-key";

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
