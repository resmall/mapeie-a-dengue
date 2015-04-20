function initialize() {
    var mapOptions = {
        zoom: 15,
        center: new google.maps.LatLng(-28.2898836,-53.4998947)
    };

    var map = new google.maps.Map(document.getElementById('map-canvas'),
    mapOptions);

    google.maps.event.addListener(map, 'click', function(e) {

        // 1 - Verifica se o usuário está logado, se não, aborta tudo e pede pra logar
        // salvarBanco(a, b, function(){})
        FB.getLoginStatus(function(response) {
            facebookStatusCheckCallback(response, e);

        });
        // 2 - Se logado, tenta salvar no banco de dados e verifica se já 
        //     excedeu o limite de 3 marcadores


        // 3 - Se conseguiu salvar no banco de dados, adiciona o marcador e mensagem de sucesso.
        
        //placeMarker(e.latLng, map);
        //saveToDatabase(e.latLng.lat(), e.latLng.lng());
        //alert(e.latLng.lat());
    });
}

function facebookStatusCheckCallback(response, e) {
    if(response.status != 'connected') {
        // adicionar o botao do facebook login na modal pra facilitar
        setModal('Aviso', 'Para poder marcar no mapa, é necessário se logar usando o Facebook.');
        // ativa o modal bootstrap
        $('#myModal').modal();
    } else {  // connected, tenta salvar e retorna
        saveToDatabase(e.latLng.lng(), e.latLng.lat());
    }
}
            
function placeMarker(position, map) {
    var marker = new google.maps.Marker({
        position: position,
        map: map
    });
    map.panTo(position);
}

function saveToDatabase(lng, lat) {
    FB.api('/me', function(response) {
        var username = response.email;
        console.log('username   ' + username);
     
        $.post( "src/saveLocalization.php", { lng: lng, lat: lat, username: username } )
        .done(function(data) {
            setModal('Aviso', data.message);
            $('#myModal').modal();
        })
        .fail(function() {
            setModal('Erro', 'Ocorreu um erro durante a execução do script.');
            $('#myModal').modal();
        });
    });
}


function setModal(title, message) {
    $("#myModal .modal-title").html(title);
    $("#myModal .modal-body").html(message);
}

google.maps.event.addDomListener(window, 'load', initialize);