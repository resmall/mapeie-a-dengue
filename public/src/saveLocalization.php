<?php 
require('../../autoload.php');
// usando o autload do composer, facil, pratico e carrega nossos
// pacotes, uma beleza
require __DIR__ .'/../../vendor/autoload.php';


use App\Dengue\Location\Location;
use App\Dengue\Location\LocationFactory;


// Auth Facebook
use OAuth\OAuth2\Service\Facebook;
use OAuth\Common\Storage\Session;
use OAuth\Common\Consumer\Credentials;


// initialize
$row['message'] = '';

$location = new LocationFactory();
$location = $location->getLocationObject($_POST['lng'], $_POST['lat']);


$storage = new Session();


if(is_null($location)) {
    $row['message'] = "Dados incorretos";
} else {

    try {
        $mysqli = new mysqli("localhost", "homestead", "secret", "dengue");
        $result = $mysqli->query("SELECT id FROM dengue WHERE username = 'tiago'");
    } catch(mysqli_sql_exception $e) {
        throw $e; 
    }

        
    if ($result->num_rows <= 3 ) {
        // pode gravar
        // gravarLocalizacao()
        $row['message'] = 'Não Tem';
        $result = $mysqli->query(
            "INSERT INTO dengue (username, lng, lat) 
            VALUES (
                'tiago',".
                 $location->getLongitude() .",".
                 $location->getLatitude() .");"
                /*$location->getLongitude()*/
                /*$location->getLatitude() */ 
        
        );

        if($result == false)
            $row['message'] = "Falha, tente mais tarde";
    } else {
        // não pode gravar
        $row['message'] = "Você adicionou o máximo de marcações possíveis para a sua conta.";
    }
}

//echo htmlentities($row['_message']);
echo json_encode($row);

// verifica se a pessoa já marcou 3 spots
// se marcou não pode marcar mais
// se não marcou, salva e retorna confirmação

