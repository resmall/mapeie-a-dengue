<?php 
require('../../autoload.php');
// usando o autload do composer, facil, pratico e carrega nossos
// pacotes, uma beleza
require __DIR__ .'/../../vendor/autoload.php';
define("ALLOWED_MARKS_PER_USER", 3);

use App\Dengue\Location\Location;
use App\Dengue\Location\LocationFactory;


// initialize
$return_message['message'] = '';
$return_message['status'] = 'error';

//tratar

$username = $_POST['username'];

//echo json_encode($username);
//exit();

$location = new LocationFactory();
$location = $location->getLocationObject($_POST['lng'], $_POST['lat']);

if(is_null($location)) {
    $return_message['message'] = "Dados incorretos";
} else {

    try {
        $mysqli = new mysqli("localhost", "homestead", "secret", "dengue");

        if (mysqli_connect_errno()) {
            $return_message['message'] = "Houve uma falha na conexão, seguem detalhes.". mysqli_connect_error();
            echo json_encode($return_message['message']);
            exit();
        }

        // Apesar dos dados do usuário vierm do facebook, não custa sanitizar 
        $username = $mysqli->real_escape_string($username);
        $result = $mysqli->query("SELECT id FROM dengue WHERE username = '$username'" );

    } catch(mysqli_sql_exception $e) {
        throw $e; 
    }

    if(!$result) {
        $return_message['message'] = "Erro ao tentar: \n". $mysqli->error; //$mysqli->sqlstate;

    } elseif($result->num_rows < ALLOWED_MARKS_PER_USER ) {  // psr-2
        $result = $mysqli->query(
            "INSERT INTO dengue (username, lng, lat) 
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
        // não pode gravar
        $return_message['message'] = "Você adicionou o máximo de marcações possíveis para a sua conta.";
    }
}

//echo htmlentities($return_message['_message']);
header('Content-Type: application/json');
echo json_encode($return_message);

// verifica se a pessoa já marcou 3 spots
// se marcou não pode marcar mais
// se não marcou, salva e retorna confirmação

