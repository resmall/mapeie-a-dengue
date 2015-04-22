function initialize() {
    var mapOptions = {
        zoom: 18,
        center: new google.maps.LatLng(-28.2898836,-53.4998947)
    };

    var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

    $.post("src/getMarkers.php")
    .done(function(data) {
        var obj = data; //JSON.parse(data);
        for(var i = 0; i < obj.length; i++) {
            var position = new google.maps.LatLng(obj[i].lat, obj[i].lng); //3 param bool
            placeMarker(position, map);
        }
    })
    .fail(function() {
        alert("error");
    });

    google.maps.event.addListener(map, 'click', function(e) {
        // 1 - Verifica se o usuário está logado, se não, aborta tudo e pede pra logar
        // 2 - Se logado, tenta salvar no banco de dados e verifica se já 
        //     excedeu o limite de 3 marcadores
        // 3 - Se conseguiu salvar no banco de dados, adiciona o marcador e mensagem de sucesso.
        FB.getLoginStatus(function(response) {
            if(response.status != 'connected') {
                setModal('Aviso', 'Para poder marcar no mapa, é necessário se logar usando o Facebook.');
                $('#myModal').modal(); //chama modal
            } else {  // connected, tenta salvar e retorna
                FB.api('/me', function(response) {
                    $.post( "src/saveLocalization.php", { 
                        lng: e.latLng.lng(), 
                        lat: e.latLng.lat(), 
                        username: response.email 
                    })
                    .done(function(data) {
                        setModal('Aviso', data.message);
                        $('#myModal').modal();

                        // independente da mensagem que for exibida, se deu certo, marcamos o mapa
                        if(data.status == 'success') {
                            placeMarker(e.latLng, map);
                        }
                    })
                    .fail(function() {
                        setModal('Erro', 'Ocorreu um erro durante a execução do script.');
                        $('#myModal').modal();
                    });
                });
            }
        });
    });
}
            
function placeMarker(position, map) {
    var marker = new google.maps.Marker({
        position: position,
        map: map
    });
    map.panTo(position);
}

function setModal(title, message) {
    $("#myModal .modal-title").html(title);
    $("#myModal .modal-body").html(message);
}

function loadExistingMarkers() {

}

google.maps.event.addDomListener(window, 'load', initialize);