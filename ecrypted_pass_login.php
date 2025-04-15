<?php
require_once 'mysql_conn.php';
session_start();

if (!empty($_POST['email']) && !empty($_POST['ciphertext'])) {
    $email = $_POST['email'];
    $ciphertext_base64 = $_POST['ciphertext'];
    $config = include('config.php');
    $key =  $config['encryption_key'];
    $iv =  $config['iv'];


    // Декодуємо та дешифруємо
    $ciphertext = base64_decode($ciphertext_base64);
    $decrypted_password = openssl_decrypt(
        $ciphertext,
        'aes-256-cbc',
        $key,
        OPENSSL_RAW_DATA,
        $iv
    );


    $pdo = getDbConnection();
    $stmt = $pdo->prepare("SELECT open_password FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && $user['open_password'] === $decrypted_password) {
        $_SESSION['user'] = ['email' => $email];
        echo "✅ Успішний вхід<br>";
        echo "✅ Пароль (base64 з клієнта):\n" . htmlspecialchars($ciphertext_base64) . "\n\n";
        echo "✅ Дешифрований пароль:\n" . htmlspecialchars($decrypted_password) . "\n\n";
        echo "✅ Збережений пароль у БД:\n" . htmlspecialchars($user['open_password'] ?? '[not found]') . "\n\n";
        echo "<script>setTimeout(() => location.href = 'index.php', 5000);</script>";
    } else {
        echo "❌ Невірний пароль або користувач не знайдений";
    }
} else {
    echo "⚠️ Введіть усі дані!";
}
?>
