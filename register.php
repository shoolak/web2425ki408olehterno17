<?php
include 'create_user.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']); 
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL); 
    $password = trim($_POST['password']);
    $phone = preg_replace('/\D/', '', $_POST['phone']);

    if (!preg_match('/^380\d{9}$/', $phone)) {
        die("❌ Невірний номер телефону.");
    }

    // Генеруємо код
    $code = rand(100000, 999999);
    if (!is_dir('codes')) mkdir('codes');
    file_put_contents("codes/$phone.json", json_encode([
        'code' => $code,
        'name' => $name,
        'email' => $email,
        'password' => $password
    ]));

    // 🔧 Налаштування WhatsApp Cloud API
    $config = include('config.php');
    $token =  $config['token'];
    $phone_number_id =  $config['phone_number_id'];
    $template_name = 'hello_world'; 
    $language_code = 'en_US'; 
    $url = "https://graph.facebook.com/v19.0/$phone_number_id/messages";

    $data = [
        'messaging_product' => 'whatsapp',
        'to' => $phone,
        'type' => 'template',
        'template' => [
            'name' => 'hello_world',
            'language' => ['code' => 'en_US']
        ]
    ];

    $options = [
        'http' => [
            'header'  => "Authorization: Bearer $token\r\nContent-Type: application/json\r\n",
            'method'  => 'POST',
            'content' => json_encode($data)
        ]
    ];

    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    echo "<pre>";
    print_r(json_decode($result, true));
    echo "</pre>";

    // Логування результату
    if ($result === FALSE) {
        $error = error_get_last();
        error_log("❌ Помилка надсилання в WhatsApp: " . print_r($error, true));
    } else {
        error_log("✅ WhatsApp API відповідь: " . $result);
    }

    // Переходимо на сторінку підтвердження
    
}
?>
