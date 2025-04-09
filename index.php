<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Візитка</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Моя Візитка</h1>
    <p>Ім'я: Іван Іванов</p>
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

    <script src="script.js"></script>
</body>
</html>
