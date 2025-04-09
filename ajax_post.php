<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message = htmlspecialchars($_POST['message']);
    echo "AJAX POST: $message<br>Час: " . date('Y-m-d H:i:s');
} else {
    echo "Невірний запит.";
}
?>
