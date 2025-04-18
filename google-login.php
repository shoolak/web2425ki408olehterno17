<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'vendor/autoload.php';

session_start();

$client = new Google_Client();
$config = include('config.php'); 

$client->setClientId($config['google_client_id']);
$client->setClientSecret($config['google_client_secret']);
if ($_SERVER['SERVER_NAME'] == 'localhost') {
    $client->setRedirectUri('http://localhost/phpproj/web2425ki408olehterno17/google-callback.php'); 
} else {
    $client->setRedirectUri('http://http://dsadtestphplab.wuaze.com/google-callback.php'); 
}
$client->addScope('email');
$client->addScope('profile');

$auth_url = $client->createAuthUrl();
header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
exit;
