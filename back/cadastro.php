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

$senha_hash = password_hash($senha, PASSWORD_DEFAULT); 

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

try {
    
    $query_select = "SELECT login FROM usuarios WHERE login = ?";
    $stmt = mysqli_prepare($connect, $query_select);
    if (!$stmt) {
        throw new Exception("Erro ao preparar a consulta de verificação de login: " . mysqli_error($connect));
    }
    mysqli_stmt_bind_param($stmt, 's', $login);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) > 0) {
        echo json_encode(["status" => "error", "message" => "Esse login já existe"]);
    } else {
        $query = "INSERT INTO usuarios (login, senha) VALUES (?, ?)";
        $stmt_insert = mysqli_prepare($connect, $query);
        if (!$stmt_insert) {
            throw new Exception("Erro ao preparar a consulta de inserção: " . mysqli_error($connect));
        }
        mysqli_stmt_bind_param($stmt_insert, 'ss', $login, $senha_hash);

        if (mysqli_stmt_execute($stmt_insert)) {
           
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

            echo json_encode(["status" => "success", "message" => "Usuário cadastrado com sucesso!", "token" => $token]);
        } else {
            throw new Exception("Erro ao executar a consulta de inserção no banco de dados: " . mysqli_error($connect));
        }
    }

    mysqli_stmt_close($stmt);
} catch (Exception $e) {
   
    echo json_encode(["status" => "error", "errorName" => $e->getMessage(), "message" => "Não foi possível cadastrar."]);
}

mysqli_close($connect);

?>
