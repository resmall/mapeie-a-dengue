<?php 
// 1 - pegar todos os marcadores do banco de dados (ideal seria pegar só da área focada, não todos)
// 2 - retornar um json com a posição dos marcadores
$return_message['message'] = '';
$return_message['status'] = '';

try {
    $mysqli = new mysqli("localhost", "homestead", "secret", "dengue");

    if (mysqli_connect_errno()) {
        $return_message['message'] = "Houve uma falha na conexão, seguem detalhes.". mysqli_connect_error();
        echo json_encode($return_message['message']);
        exit();
    }

    $result = $mysqli->query("SELECT * FROM dengue" );
} catch(mysqli_sql_exception $e) {
    throw $e; 
}

if(!$result) {
    $return_message['message'] = "Erro ao tentar: \n". $mysqli->error; //$mysqli->sqlstate;
} else {
    header('Content-Type: application/json');
    echo json_encode($result->fetch_all($resulttype = MYSQLI_ASSOC));
    exit();
}

echo json_encode($return_message);