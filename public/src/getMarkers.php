<?php 
require __DIR__ .'/../../vendor/autoload.php';
use Noodlehaus\Config;

// 1 - pegar todos os marcadores do banco de dados (ideal seria pegar só da área focada, não todos)
// 2 - retornar um json com a posição dos marcadores
$return_message['message'] = '';
$return_message['status'] = 'failed';


$slat = $_POST['southwest_lat'];
$slng = $_POST['southwest_lng'];
$nlat = $_POST['northeast_lat'];
$nlng = $_POST['northeast_lng'];

// Iniciando objeto com as configurações no diretório.. e repetindo código de novo
$config = new Config(__DIR__ . '/../../app/config');

try {
    // que feio, estamos repetindo código
    $mysqli = new mysqli($config->get('connections.mysql.host'), 
                         $config->get('connections.mysql.username'), 
                         $config->get('connections.mysql.password'), 
                         $config->get('connections.mysql.database'));

    if (mysqli_connect_errno()) {
        $return_message['message'] = "Houve uma falha na conexão, seguem detalhes.". mysqli_connect_error();
        echo json_encode($return_message['message']);
        exit();
    }
//lat lng
    //$result = $mysqli->query("SELECT * FROM marcacoes" );
    $result = $mysqli->query("SELECT * FROM marcacoes 
                             WHERE lat > ". $slat ." AND lat < ". $nlat ." AND lng > ". $slng ." AND lng < ". $nlng
                              );
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




//if from Google: ( (a, b), (c, d) )

//SELECT * FROM tilistings WHERE lat > a AND lat < c AND lng > b AND lng < d