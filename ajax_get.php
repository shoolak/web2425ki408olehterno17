<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $message = htmlspecialchars($_GET['message']);
    echo "AJAX GET: $message<br>Час: " . date('Y-m-d H:i:s');
} else {
    echo "Невірний запит.";
}
?>
