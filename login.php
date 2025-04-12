<!-- login.php -->

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Логін</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Вхід</h1>

    <!-- Форма для Open Password -->
    <h2>Вхід з відкритим паролем</h2>
    <form method="POST" action="open_pass_login.php">
        <label for="email">Логін:</label>
        <input type="text" id="email" name="email" required><br><br>

        <label for="password">Пароль:</label>
        <input type="password" id="password" name="password" required><br><br>

        <button type="submit">Увійти (Open Password)</button>
    </form>

    <!-- Форма для Hash Password -->
    <h2>Вхід з хешованим паролем</h2>
    <form method="POST" action="hash_pass_login.php">
        <label for="email">Логін:</label>
        <input type="text" id="email" name="email" required><br><br>

        <label for="password">Пароль:</label>
        <input type="password" id="password" name="password" required><br><br>

        <button type="submit">Увійти (Hash Password)</button>
    </form>

    <!-- Форма для Encrypted Password -->
    <h2>Вхід з зашифрованим паролем</h2>
    <form method="POST" action="ecrypted_pass_login.php">
        <label for="email">Логін:</label>
        <input type="text" id="email" name="email" required><br><br>

        <label for="password">Пароль:</label>
        <input type="password" id="password" name="password" required><br><br>

        <button type="submit">Увійти (Encrypted Password)</button>
    </form>

</body>
</html>
