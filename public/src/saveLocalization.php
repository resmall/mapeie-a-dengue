<?php 
require('../../autoload.php');
require __DIR__ .'/../../vendor/autoload.php';

use App\Dengue\Location\Location;
use App\Dengue\Location\LocationFactory;
use Noodlehaus\Config;

// Constante que define quantas marcações o usuário pode fazer
define("ALLOWED_MARKS_PER_USER", 3);

// E-mail do usuário no Facebook
$username = $_POST['username'];

// Inicilizando array dos retornos
$return_message['message'] = '';
$return_message['status'] = 'error';

// Iniciando objeto com as configurações no diretório
$config = new Config(__DIR__ . '/../../app/config');

// Iniciando o objeto que guarda as localizações e as valida
$location = new LocationFactory();
$location = $location->getLocationObject($_POST['lng'], $_POST['lat']);

if(is_null($location)) {
    $return_message['message'] = "Dados incorretos";
} else {
    try {
        $mysqli = new mysqli($config->get('connections.mysql.host'), 
                             $config->get('connections.mysql.username'), 
                             $config->get('connections.mysql.password'), 
                             $config->get('connections.mysql.database'));

        if (mysqli_connect_errno()) {
            $return_message['message'] = "Houve uma falha na conexão, seguem detalhes.". mysqli_connect_error();
            echo json_encode($return_message['message']);
            exit();
        }

        // Apesar dos dados do usuário vierm do facebook, não custa sanitizar 
        $username = $mysqli->real_escape_string($username);
        $result = $mysqli->query("SELECT id FROM marcacoes WHERE username = '$username'" );

    } catch(mysqli_sql_exception $e) {
        throw $e; 
    }

    if(!$result) {
        // Erro na consulta
        $return_message['message'] = "Erro na consulta: \n". $mysqli->error; //$mysqli->sqlstate;
    } elseif( true /*$result->num_rows < ALLOWED_MARKS_PER_USER*/ ) {  // psr-2
        // Se o usuário não marcou o máximo permitido, faz a gravação
        $result = $mysqli->query(
            "INSERT INTO marcacoes (username, lng, lat) 
            VALUES ('".
                $username ."',".
                $location->getLongitude() .",".
                $location->getLatitude() .");"        
        );

        if(!$result) {
            $return_message['message'] = "Ocorreu uma falha durante o processo de gravação";
        } else {
            $return_message['message'] = 'Gravação realizada com sucesso.';
            $return_message['status'] = 'success';
        }
    } else {
        // Já atingiu o limite
        $return_message['message'] = "Você adicionou o máximo de marcações possíveis para a sua conta.";
    }
}

header('Content-Type: application/json');
echo json_encode($return_message);
