var map ;
// Array que guarda todos os marcadores do mapa
var markers = [];
// array que guarda o id dos marcadores pra saber o que foi adicionado ou não
var markerstable = [];
// objeto que detém os marcadores agrupados, se encarrega de agrupar e exibir
var markerCluster;

function initialize() {
    var mapOptions = {
        zoom: 15,
        center: new google.maps.LatLng(-28.2898836,-53.4998947),
        disableDoubleClickZoom: true,
    };

    // objeto que detém a referência para o mapa exibido
    map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
    // objeto que detém os marcadores agrupados, se encarrega de agrupar e exibir
    markerCluster = new MarkerClusterer(map);

    // adiciona o listenter do click no map-canvas
    google.maps.event.addListener(map, 'dblclick', function(e) {
        // 1 - Verifica se o usuário está logado, se não, aborta tudo e pede pra logar
        // 2 - Se logado, tenta salvar no banco de dados e verifica se já 
        //     excedeu o limite de 3 marcadores
        // 3 - Se conseguiu salvar no banco de dados, adiciona o marcador e mensagem de sucesso.
        FB.getLoginStatus(function(response) {
            if(response.status != 'connected') {
                setModal('Aviso', 'Para poder marcar no mapa, é necessário se logar usando o Facebook.');
                showModal();
            } else {  // connected, tenta salvar e retorna
                FB.api('/me', function(response) {
                    $.post( "src/saveLocalization.php", { 
                        lng: e.latLng.lng(), 
                        lat: e.latLng.lat(), 
                        username: response.email 
                    })
                    .done(function(data) {        
                        // independente da mensagem que for exibida, se deu certo, marcamos o mapa
                        if(data.status == 'success') {
                            markerCluster.addMarker(new google.maps.Marker({
                                position: e.latLng,
                                map: map
                            }));
                            // TODO: pdoeria retornar o id criado pra atualizar a tabela
                            console.log("#2" + markerCluster);
                        }
                        setModal('Aviso', data.message);
                        showModal();
                    })
                    .fail(function() {
                        setModal('Erro', 'Ocorreu um erro durante a execução do script.');
                        showModal();
                    });
                });
            }
        });
    });

    // depois q carregou, chamamos os inicializadores
    google.maps.event.addListenerOnce(map, 'idle', function(){
        getPositionsFromBounds(map);
        
    });

    // queremos que após arrastar o mapa os marcadores sejam carregados
    google.maps.event.addListener(map, 'dragend', function(e) {
        // 1 - No início ou ao mover o mapa:
        // 2 - obter as bordas do mapa, pra saber quais marcadores buscar
        // 3 - buscar no banco os marcadores, que estão dentro das bordas do mapa
        // 4 - Excluir os marcadores que estão fora da área de visualização.
        //     Exemplo: deletar marcadores que estão fora da borda + 10%
        clearMarkersNotInView(map.getBounds(), markers);
        getPositionsFromBounds(map);
    });

    // queremos que quando o zoom mudar os marcadores também sejam alterados
    google.maps.event.addListener(map, 'zoom_changed', function() {
        google.maps.event.trigger(this, 'dragend');
    });
}

function setModal(title, message) {
    $("#myModal .modal-title").html(title);
    $("#myModal .modal-body").html(message);
}

function showModal() {
    $('#myModal').modal();
}

/*
 * Remove os marcadores que não aparecem na view
 */
function clearMarkersNotInView(bounds, markers) {
    var debug_count = 0;

    for(var i = 0; i < markers.length; i++) {
        if(!bounds.contains(markers[i].getPosition())) {
            markers[i].setMap(null); // tira do mapa
            markers.splice(i, 1); // tira do array
            markerstable.splice(i,1);
            debug_count++;
        }            
    } 

    // limpamos os marcadores
    markerCluster.clearMarkers();
    console.log(debug_count + " itens removidos. " + markers.length + " restantes");
}

/*
 * Recupera as marcações de acordo com a posição da view
 */
function getPositionsFromBounds(map) {
    var bounds = {
        southwest_lat: map.getBounds().getSouthWest().lat(),
        southwest_lng: map.getBounds().getSouthWest().lng(),
        northeast_lat: map.getBounds().getNorthEast().lat(),
        northeast_lng: map.getBounds().getNorthEast().lng()
    };

    $.post("src/getMarkers.php", bounds)
    .done(function(data) {
        for(var i = 0; i < data.length; i++) {
            // verifica se o id ja existe, se existir nao add novamente
            if(markerstable.indexOf(data[i].id) == -1) {
                var position = new google.maps.LatLng(data[i].lat, data[i].lng); //3 param bool
                markers.push(new google.maps.Marker({'position': position}));
                markerstable.push(data[i].id);
            } 
        }
        console.log("Marcadors: " + markers.length + " ID Guardados: " + markerstable.length);
        updateMarkerCluster(markers);
    })
    .fail(function() {
        console.log("Abort, shit detected!");
    });
}

function updateMarkerCluster() {
    markerCluster.addMarkers(markers);
    console.log("Marcadores atualizados");
}

google.maps.event.addDomListener(window, 'load', initialize);