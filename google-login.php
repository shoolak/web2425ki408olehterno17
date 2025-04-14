<?php
require_once 'vendor/autoload.php';

session_start();

$client = new Google_Client();
$config = include('config.php'); 

$client->setClientId($config['google_client_id']);
$client->setClientSecret($config['google_client_secret']);
if ($_SERVER['SERVER_NAME'] == 'localhost') {
    $client->setRedirectUri('http://localhost/web_business_card/web2425ki408olehterno17/google-callback.php'); 
} else {
    $client->setRedirectUri('http://labwebphpnulp.infinityfreeapp.com/google-callback.php'); 
}
$client->addScope('email');
$client->addScope('profile');

$auth_url = $client->createAuthUrl();
header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
exit;
