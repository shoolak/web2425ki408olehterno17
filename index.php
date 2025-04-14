<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Візитка</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Моя Візитка</h1>
    <p>Ім'я: Олег Т</p>
    <p>Проект: Сайт візитка</p>

    <p>Дата та час завантаження сторінки: <?php echo date('Y-m-d H:i:s'); ?></p>

    <h2>POST форма</h2>
    <form action="post_page.php" method="POST">
        <input type="text" name="message" placeholder="Напишіть щось">
        <button type="submit">Відправити через POST</button>
    </form>

    <h2>GET форма</h2>
    <form action="get_page.php" method="GET">
        <input type="text" name="message" placeholder="Напишіть щось">
        <button type="submit">Відправити через GET</button>
    </form>

    <h2>POST AJAX форма</h2>
    <form id="ajaxPostForm">
        <input type="text" name="message" placeholder="Повідомлення через AJAX POST">
        <button type="submit">Відправити AJAX POST</button>
    </form>
    <div id="postResult"></div>

    <h2>GET AJAX форма</h2>
    <form id="ajaxGetForm">
        <input type="text" name="message" placeholder="Повідомлення через AJAX GET">
        <button type="submit">Відправити AJAX GET</button>
    </form>
    <div id="getResult"></div>

    <!-- Форма реєстрації -->
    <h2>Реєстрація</h2>
    <form action="create_user.php" method="POST">
        <label for="name">Ім'я:</label>
        <input type="text" id="name" name="name" required><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>

        <label for="password">Пароль:</label>
        <input type="password" id="password" name="password" required><br><br>

        <button type="submit">Зареєструватися</button>
    </form>
    
    <?php session_start(); ?>
    <?php if (isset($_SESSION['user'])): ?>
        <p> Привіт, <?= htmlspecialchars($_SESSION['user']['email']) ?>!</p>
        <a href="logout.php">Вийти</a>
    <?php else: ?>
        <a href="login.php">Увійти</a>
    <?php endif; ?>


    <script src="script.js"></script>
</body>
</html>
