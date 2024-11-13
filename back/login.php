<?php

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
require_once __DIR__ . '/vendor/autoload.php';
$login = $_POST["login"] ?? '';
$senha = $_POST["senha"] ?? '';

if (empty($login) || empty($senha)) {
    echo json_encode(["status" => "error", "message" => "Os campos login e senha devem ser preenchidos"]);
    exit();
}

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();


$connect = mysqli_connect(
    getenv('DB_HOST'), 
    getenv('DB_USER'), 
    getenv('DB_PASSWORD'), 
    getenv('DB_NAME')
);

if (!$connect) {
    echo json_encode(["status" => "error", "message" => "Conexão falhou: " . mysqli_connect_error()]);
    exit();
}

$query = "SELECT senha FROM usuarios WHERE login = ?";
$stmt = mysqli_prepare($connect, $query);
mysqli_stmt_bind_param($stmt, 's', $login);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $senha_hash);

if (mysqli_stmt_fetch($stmt)) {
    if (password_verify($senha, $senha_hash)) {
       
        $duracao = time() + (7 * 24 * 60 * 60);
        $header = json_encode(['alg' => 'HS256', 'typ' => 'JWT']);
        $payload = json_encode([
            'iss' => 'localhost',
            'aud' => 'localhost',
            'exp' => $duracao,
            'login' => $login
        ]);

        $header = base64_encode($header);
        $payload = base64_encode($payload);
        $chave = '1DJMASDFXR12DF678';
        $signature = hash_hmac('sha256', "$header.$payload", $chave, true);
        $signature = base64_encode($signature);
        $token = "$header.$payload.$signature";
        
        setcookie("token", $token, $duracao, "/");

        echo json_encode(["status" => "success", "message" => "Login bem-sucedido!", "token" => $token]);
    } else {
        echo json_encode(["status" => "error", "message" => "Senha incorreta"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Usuário não encontrado"]);
}

mysqli_stmt_close($stmt);
mysqli_close($connect);
