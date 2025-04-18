<?php
include 'create_user.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Отримання та очищення даних
    $name = trim($_POST['name']); 
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL); 
    $password = trim($_POST['password']);
    $phone = preg_replace('/\D/', '', $_POST['phone']);

    // Перевірка телефону
    if (!preg_match('/^380\d{9}$/', $phone)) {
        die("❌ Невірний номер телефону. Має починатися з 380 та містити 12 цифр.");
    }

    // Генеруємо код підтвердження
    $code = rand(100000, 999999);

    // Створюємо папку та зберігаємо дані
    if (!is_dir('codes')) mkdir('codes');
    file_put_contents("codes/$phone.json", json_encode([
        'code' => $code,
        'name' => $name,
        'email' => $email,
        'password' => $password
    ]));

    // WhatsApp Cloud API: конфіг
    $config = include('config.php');
    $token =  $config['token'];
    $phone_number_id =  $config['phone_number_id'];
    $template_name = 'hello_world'; 
    $language_code = 'en_US'; 
    $url = "https://graph.facebook.com/v19.0/$phone_number_id/messages";

    // Формуємо повідомлення (payload)
    $payload = [
        'messaging_product' => 'whatsapp',
        'to' => $phone,
        'type' => 'template',
        'template' => [
            'name' => $template_name,
            'language' => ['code' => $language_code]
        ]
    ];

    // CURL-запит до WhatsApp API
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $token,
        'Content-Type: application/json'
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));

    $response = curl_exec($ch);
    $error = curl_error($ch);
    curl_close($ch);

    if ($error) {
        echo "❌ CURL Error: $error";
    } else {
        echo "✅ Користувача успішно зареєстровано!<br>";
        echo "📲 Відповідь WhatsApp API: $response";
    }

    // Можна додати переадресацію або сторінку підтвердження
    // header('Location: confirm.php?phone=' . $phone);
}
?>
