<?php
    
    session_name("tasselhof");
    session_start();

    // Bootup the Composer autoloader
    include __DIR__ . '/vendor/autoload.php';  

    use Mautic\Auth\ApiAuth;
    
    $baseUrl = 'http://localhost/conteudo';
    $publicKey = 'alcrm5iergg040c408owwkcgk4sk00sg4c0kkwcw4040g4oos';
    $secretKey = '3aphl7804y4g4wgkc804o400s08swc8g8s4oogc4kkcgwww000';
    $callback  = 'http://localhost/prime_organizer/tb_contato_view.php';

    // ApiAuth->newAuth() will accept an array of Auth settings
    $settings = array(
        'baseUrl'          => $baseUrl,       // Base URL of the Mautic instance
        'version'          => 'OAuth1a', // Version of the OAuth can be OAuth2 or OAuth1a. OAuth2 is the default value.
        'clientKey'        => $publicKey,       // Client/Consumer key from Mautic
        'clientSecret'     => $secretKey,       // Client/Consumer secret key from Mautic
        'callback'         => $callback        // Redirect URI/Callback URI for this script
    );

    /*
    // If you already have the access token, et al, pass them in as well to prevent the need for reauthorization
    if(isset($_SESSION['accessToken'])){
        $settings['accessToken']        = $_SESSION['accessToken'];
        $settings['accessTokenSecret']  = $_SESSION['accessTokenSecret']; //for OAuth1.0a
        $settings['accessTokenExpires'] = $_SESSION['accessTokenExpires']; //UNIX timestamp
        $settings['refreshToken']       = $refreshToken;
    }
    */

    // Initiate the auth object
    $auth = new ApiAuth();
    $auth = $auth->initiate($settings);

    // Initiate process for obtaining an access token; this will redirect the user to the $authorizationUrl and/or
    // set the access_tokens when the user is redirected back after granting authorization

    // If the access token is expired, and a refresh token is set above, then a new access token will be requested

    try {
        if ($auth->validateAccessToken()) {

            // Obtain the access token returned; call accessTokenUpdated() to catch if the token was updated via a
            // refresh token

            // $accessTokenData will have the following keys:
            // For OAuth1.0a: access_token, access_token_secret, expires
            // For OAuth2: access_token, expires, token_type, refresh_token

            if ($auth->accessTokenUpdated()) {
                $accessTokenData = $auth->getAccessTokenData();
                
                $_SESSION['accessToken'] = $accesTokenData['access_token'];
                $_SESSION['accessTokenSecret'] = $accesTokenData['access_token_secret'];
                $_SESSION['accessTokenExpires'] = $accesTokenData['access_token_expires'];
                
                print_r($accessTokenData);
                //store access token data however you want
            }
        }
    } catch (Exception $e) {
        // Do Error handling
        print_r($e);
    }
?>