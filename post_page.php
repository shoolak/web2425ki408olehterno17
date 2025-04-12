<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message = htmlspecialchars($_POST['message']);
    echo "<h1>POST Сторінка</h1>";
    echo "<p>Ваше повідомлення: $message</p>";
    echo "<p>Дата та час: " . date('Y-m-d H:i:s') . "</p>";
} else {
    echo "Невірний запит.";
}
?>
