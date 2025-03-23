<?php
header('Content-Type: application/json; charset=UTF-8');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $account_uid = $_GET['account_uid'] ?? null;
    $datadome = $_GET['datadome'] ?? "HfMB_IAV7n1ukAwspLFKxECKCRG29zGP1MIHyEet5_uPyo2hyIfNOwUkUseVibwwpLamoRBFB6ZldreSo_0qa5Piv3f~qJd_0n0PrR8oZWGCaNafifAyAAMIh1KRfbzc";

    if (!$account_uid) {
        echo json_encode(['error' => 'error account_uid']);
        exit;
    }

    $headers = [
        "User-Agent: Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Mobile Safari/537.36",
        "Accept: application/json",
        "Content-Type: application/json",
        "sec-ch-ua: \"Not-A.Brand\";v=\"99\", \"Chromium\";v=\"124\"",
        "x-datadome-clientid: $datadome",
        "sec-ch-ua-mobile: ?1",
        "sec-ch-ua-platform: \"Android\"",
        "Origin: https://napthe.vn",
        "Sec-Fetch-Site: same-origin",
        "Sec-Fetch-Mode: cors",
        "Sec-Fetch-Dest: empty",
        "Referer: https://napthe.vn/app/100067/idlogin",
        "Accept-Language: vi-VN,vi;q=0.9,fr-FR;q=0.8,fr;q=0.7,en-US;q=0.6,en;q=0.5",
        "Cookie: source=mb; mspid2=1a8665f2a24f5f5e310f181cca289f15"
    ];

    $payload = json_encode([
        "app_id" => 100067,
        "login_id" => $account_uid,
        "app_server_id" => 0,
        "client_secret" => "2ee44819e9b4598845141067b281621874d0d5d7af9d8f7e00c1e54715b7d1e3",
        "client_id" => "100067"
    ]);

    $ch = curl_init('https://napthe.vn/api/auth/player_id_login');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

    $response = curl_exec($ch);
    $error = curl_error($ch);
    curl_close($ch);

    if ($error) {
        echo json_encode(['error' => $error]);
        exit;
    }

    $response = json_decode($response, true);

    if (isset($response['error'])) {
        echo json_encode(['error' => $response['error']]);
        exit;
    }

    $region = $response['region'] ?? "error";
    $nickname = isset($response['nickname']) ? strip_tags($response['nickname']) : "error";
    $nickname = preg_replace('/[<>]/', '', $nickname);

    echo json_encode([
        'region' => $region,
        'nickname' => $nickname
    ], JSON_UNESCAPED_UNICODE);
}
