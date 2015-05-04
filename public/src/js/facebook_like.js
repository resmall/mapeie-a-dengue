window.fbAsyncInit = function() {
    FB.init({
        appId      : '1592670777645457',  //'1591339704445231' <- producao
        cookie     : true,  // enable cookies to allow the server to access 
                            // the session
        xfbml      : true,  // parse social plugins on this page
        version    : 'v2.3' // use version 2.3
    });

    checkLoginState();
};

// This is called with the results from from FB.getLoginStatus().
function statusChangeCallback(response) {
    // The response object is returned with a status field that lets the
    // app know the current login status of the person.
    // Full docs on the response object can be found in the documentation
    // for FB.getLoginStatus().
    if (response.status === 'connected') {
      // Logged into your app and Facebook.
      showFacebookControls(false);
      testAPI();
    } else if (response.status === 'not_authorized') {
      // The person is logged into Facebook, but not your app.
      document.getElementById('status').innerHTML = 'Por favor ' +
        'faça login no app.';
        showFacebookControls(true);
    } else {
      // The person is not logged into Facebook, so we're not sure if
      // they are logged into this app or not.
      document.getElementById('status').innerHTML = 'Por favor ' +
        'faça login no Facebook.';
        showFacebookControls(true);
    }
}

// This function is called when someone finishes with the Login
// Button.  See the onlogin handler attached to it in the sample
// code below.
function checkLoginState() {
    FB.getLoginStatus(function(response) {
        statusChangeCallback(response);
    });
}

function showFacebookControls(bShow) {
    if(bShow) {
        $('#facebook-controls').show();
        return;
    }
    $('#facebook-controls').hide();
}

(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) {return;}
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

function testAPI() {
    console.log('Bem-vindo!  Obtendo dados.... ');
    FB.api('/me', function(response) {
        console.log('Login realizado com sucesso para: ' + response.name);
        document.getElementById('status').innerHTML =
            'Obrigado por se logar, ' + response.name + '!';
    });
}