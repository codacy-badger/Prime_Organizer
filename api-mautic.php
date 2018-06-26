<?php
    include __DIR__ . '/vendor/autoload.php';  

    use Mautic\Auth\ApiAuth;

    session_start();

    // ApiAuth->newAuth() will accept an array of Auth settings
    $settings = array(
        'userName'   => '',             // Create a new user       
        'password'   => ''              // Make it a secure password
    );

    // Initiate the auth object specifying to use BasicAuth
    $initAuth = new ApiAuth();
    $auth = $initAuth->newAuth($settings, 'BasicAuth');
    
    // check if Base URL, Consumer/Client Key and Consumer/Client secret are not empty
    if(!isset($_POST['mauticBaseUrl']) || !isset($_POST['clientKey']) || !isset($_POST['clientSecret'])){
        header('HTTP/1.0 401 Unauthorized');
        exit;
    }

    // @todo load this array from database / config file
    $accessTokenData = array(
        'accessToken' => '',
        'accessTokenSecret' => '',
        'accessTokenExpires' => ''
    );

    // Make sure it starts with http/https and doesn't end with '/'
    $mauticBaseUrl = $_POST['mauticBaseUrl'];

    $settings = array(
        'clientKey'         => $_POST['clientKey'],
        'clientSecret'      => $_POST['clientSecret'],
        'callback'          => 'http://localhost/prime_organizer', // Change this to your app callback. It should be the same as you entered when you were creating Mautic API credentials.
        'accessTokenUrl'    => $mauticBaseUrl . '/oauth/v1/access_token',
        'authorizationUrl'  => $mauticBaseUrl . '/oauth/v1/authorize',
        'requestTokenUrl'   => $mauticBaseUrl . '/oauth/v1/request_token'
    );

    if (!empty($accessTokenData['accessToken']) && !empty($accessTokenData['accessTokenSecret'])) {
        $settings['accessToken']        = $accessTokenData['accessToken'] ;
        $settings['accessTokenSecret']  = $accessTokenData['accessTokenSecret'];
        $settings['accessTokenExpires'] = $accessTokenData['accessTokenExpires'];
    }

    $auth = \Mautic\Auth\ApiAuth::initiate($settings);

    if ($auth->validateAccessToken()) {
        if ($auth->accessTokenUpdated()) {
            $accessTokenData = $auth->getAccessTokenData();
            // Save $accessTokenData
            $_GLOBALS['accessTokenData'] = $accessTokenData;
            
            // @todo Display success authorization message
            echo('Authorization: Basic '. $accessTokenData);
            // exit;
        } else {
            // @todo Display info message that this app is already authorized.
            
        }
    }

?>