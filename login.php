<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Логін</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Вхід</h1>

    <!-- Вхід з відкритим паролем -->
    <h2>Вхід з відкритим паролем</h2>
    <form method="POST" action="open_pass_login.php">
        <label for="email">Логін:</label>
        <input type="text" name="email" required><br><br>
        <label for="password">Пароль:</label>
        <input type="password" name="password" required><br><br>
        <button type="submit">Увійти (Open Password)</button>
    </form>

    <!-- Вхід з хешованим паролем -->
    <h2>Вхід з хешованим паролем</h2>
    <form method="POST" action="hash_pass_login.php">
        <label for="email">Логін:</label>
        <input type="text" name="email" required><br><br>
        <label for="password">Пароль:</label>
        <input type="password" name="password" required><br><br>
        <button type="submit">Увійти (Hash Password)</button>
    </form>

    <!-- Вхід із зашифрованим паролем -->
    <h2>Вхід із зашифрованим паролем (AES)</h2>
    <form method="POST" action="ecrypted_pass_login.php" onsubmit="return encryptAndSend();">
        <label>Email:</label>
        <input type="text" id="email" name="email" required><br><br>

        <label>Пароль:</label>
        <input type="password" id="passwordInput" required><br><br>

        <input type="hidden" id="ciphertext" name="ciphertext">
        <button type="submit">Увійти</button>
    </form>

    <!-- Передаємо ключі з PHP до JS -->
    <?php
    $config = include('config.php');
    $key = $config['encryption_key'];
    $iv = $config['iv'];
    ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.1.1/crypto-js.min.js"></script>
    <script>
    function encryptAndSend() {
        const password = document.getElementById("passwordInput").value;
        const email = document.getElementById("email").value;

        // Передані значення з PHP
        const key = CryptoJS.enc.Utf8.parse("<?= $key ?>");
        const iv = CryptoJS.enc.Utf8.parse("<?= $iv ?>");

        const encrypted = CryptoJS.AES.encrypt(password, key, {
            iv: iv,
            mode: CryptoJS.mode.CBC,
            padding: CryptoJS.pad.Pkcs7
        });

        const ciphertextBase64 = encrypted.ciphertext.toString(CryptoJS.enc.Base64);

        document.getElementById("ciphertext").value = ciphertextBase64;
        document.getElementById("passwordInput").value = "";

        return true;
    }
    </script>

    <!-- Google логін -->
    <h2>Вхід через Google</h2>
    <a href="google-login.php"><button>Увійти з Google</button></a>

    
</body>
</html>
