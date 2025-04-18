<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'vendor/autoload.php';
require_once 'mysql_conn.php';

session_start();

$client = new Google_Client();
$config = include('config.php'); 

$client->setClientId($config['google_client_id']);
$client->setClientSecret($config['google_client_secret']);
if ($_SERVER['SERVER_NAME'] == 'localhost') {
    $client->setRedirectUri('http://localhost/phpproj/web2425ki408olehterno17/google-callback.php'); 
} else {
    $client->setRedirectUri('http://dsadtestphplab.wuaze.com/google-callback.php'); 
}

$client->addScope('email');
$client->addScope('profile');

if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $client->setAccessToken($token);

    // Отримуємо дані користувача
    $oauth2 = new Google_Service_Oauth2($client);
    $google_user = $oauth2->userinfo->get();

    $email = $google_user->email;
    $name = $google_user->name;

    // Підключення до БД
    $pdo = getDbConnection();

    // Перевірка, чи користувач вже існує
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if (!$user) {
        echo "❌ Користувача з таким емейлом не існує";
        exit();
    }
    $_SESSION['user'] = [
        'name' => $name,
        'email' => $email
    ];
    
 
    header("Location: index.php");
    exit();

    
} else {
    echo "❌ Код не надано.";
}
