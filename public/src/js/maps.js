function initialize() {
    var mapOptions = {
        zoom: 15,
        center: new google.maps.LatLng(-28.2898836,-53.4998947)
    };

    var map = new google.maps.Map(document.getElementById('map-canvas'),
    mapOptions);

    google.maps.event.addListener(map, 'click', function(e) {

        // 1 - Verifica se o usuário está logado, se não, aborta tudo e pede pra logar
        FB.getLoginStatus(function(response) {
            facebookStatusCheckCallback(response);
        });
        // 2 - Se logado, tenta salvar no banco de dados e verifica se já 
        //     excedeu o limite de 3 marcadores
        // 3 - Se conseguiu salvar no banco de dados, adiciona o marcador e mensagem de sucesso.
        
        //placeMarker(e.latLng, map);
        //saveToDatabase(e.latLng.lat(), e.latLng.lng());
        //alert(e.latLng.lat());
    });
}

function facebookStatusCheckCallback(response) {
    if(response.status != 'connected') {
        // ativa o modal bootstrap
        $('#myModal').modal();
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
    $.post( "src/saveLocalization.php", { lng: lng, lat: lat } )
    .done(function(data) {
        alert("Retorno:" + data);
    });
}

google.maps.event.addDomListener(window, 'load', initialize);