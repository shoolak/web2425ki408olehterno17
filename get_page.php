<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $message = htmlspecialchars($_GET['message']);
    echo "<h1>GET Сторінка</h1>";
    echo "<p>Ваше повідомлення: $message</p>";
    echo "<p>Дата та час: " . date('Y-m-d H:i:s') . "</p>";
} else {
    echo "Невірний запит.";
}
?>
