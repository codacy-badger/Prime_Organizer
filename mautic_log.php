<?php
    
    $owner = array();
    $owner[] = null;
    $owner[] = 1;

    $firstname = array();
    $firstname[] = null;
    $firstname[] = 'Teste';
    
    $lastname = array();
    $lastname[] = null;
    $lastname[] = 'de Criação';

    $position = array();
    $position[] = null;
    $position[] = '2. Prospect';

    $email = array();
    $email[] = null;
    $email[] = 'teste@teste.com.br';

    $mobile = array();
    $mobile[] = null;
    $mobile[] = '41 9 9999 9998';

    $phone = array();
    $phone[] = null;
    $phone[] = '41 3333 4445';

    $city = array();
    $city[] = null;
    $city[] = 'Curitiba';

    $state = array();
    $state[] = null;
    $state[] = 'Parana';

    $country = array();
    $country[] = null;
    $country[] = 'Brazil';

    $points = array();
    $points[] = 0;
    $points[] = null;

    $datetime = array();
    $datetime[] = '';
    
    $timestamp = new DateTime();
    $timestamp -> setTimezone(new DateTimeZone('UTC'));
    $timestamp -> format('Y-m-d H:i:s');
    $datetime[] = $timestamp;

    $fields = array(
        'firstname' => $firstname,
        'lastname' => $lastname,
        'position' => $position,
        'email' => $email,        
        'mobile' => $mobile,
        'phone' => $phone,
        'city' => $city,
        'state' => $state,        
        'country' => $country
    );

    $data = array(
        "owner" => $owner,
        'firstname' => $firstname,
        'fields' => $fields,
        'lastname' => $lastname,
        'position' => $position,
        'email' => $email,        
        'mobile' => $mobile,
        'phone' => $phone,
        'points' => $points,
        'city' => $city,
        'state' => $state,        
        'country' => $country,
        'dateIdentified' => $datetime
    );

    echo(serialize($data));

?>