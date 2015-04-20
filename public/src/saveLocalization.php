<?php 
require('../../autoload.php');
// usando o autload do composer, facil, pratico e carrega nossos
// pacotes, uma beleza
require __DIR__ .'/../../vendor/autoload.php';
define("ALLOWED_MARKS_PER_USER", 3);

use App\Dengue\Location\Location;
use App\Dengue\Location\LocationFactory;


// Auth Facebook
use OAuth\OAuth2\Service\Facebook;
use OAuth\Common\Storage\Session;
use OAuth\Common\Consumer\Credentials;


// initialize
$row['message'] = '';

//tratar

$username = $_POST['username'];

//echo json_encode($username);
//exit();

$location = new LocationFactory();
$location = $location->getLocationObject($_POST['lng'], $_POST['lat']);



if(is_null($location)) {
    $row['message'] = "Dados incorretos";
} else {

    try {
        $mysqli = new mysqli("localhost", "homestead", "secret", "dengue");

        if (mysqli_connect_errno()) {
            $row['message'] = "Houve uma falha na conexão, seguem detalhes.". mysqli_connect_error();
            echo json_encode($row['message']);
            exit();
        }

        // Apesar dos dados do usuário vierm do facebook, não custa sanitizar 
        $username = $mysqli->real_escape_string($username);
        $result = $mysqli->query("SELECT id FROM dengue WHERE username = '$username'" );

    } catch(mysqli_sql_exception $e) {
        throw $e; 
    }

    if(!$result) {
        $row['message'] = "Erro ao tentar: \n". $mysqli->error; //$mysqli->sqlstate;

    } elseif($result->num_rows < ALLOWED_MARKS_PER_USER ) {  // psr-2
        $result = $mysqli->query(
            "INSERT INTO dengue (username, lng, lat) 
            VALUES ('".
                $username ."',".
                $location->getLongitude() .",".
                $location->getLatitude() .");"        
        );

        if(!$result) {
            $row['message'] = "Ocorreu uma falha durante o processo de gravação";
        } else {
            $row['message'] = 'Gravação realizada com sucesso.';
        }
    } else {
        // não pode gravar
        $row['message'] = "Você adicionou o máximo de marcações possíveis para a sua conta.";
    }
}

//echo htmlentities($row['_message']);
header('Content-Type: application/json');
echo json_encode($row);

// verifica se a pessoa já marcou 3 spots
// se marcou não pode marcar mais
// se não marcou, salva e retorna confirmação

