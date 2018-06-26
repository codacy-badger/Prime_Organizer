<?php
    
    $datetime = new DateTime();
    $datetime -> format('Y-m-d H:i:s');

    $data = array(
        "owner" => array(
            [0] =>  
            [1] => 1
        ),

        "firstname" => array(
            [0] =>  
            [1] => "Rodrigo"
        ),

        "fields" => array(
            "firstname" => array(
                [0] => 
                [1] => "Rodrigo"
            ),

            "lastname" => array(
                [0] =>  
                [1] => "Silva"
            ),

            "position" => array(
                [0] =>  
                [1] => "2. Prospect"
            ),

            "email" => array(
                [0] =>  
                [1] => "teste@teste.com"
            ),

            "mobile" => array(
                [0] =>  
                [1] => "41 9 9999 9999"
            ),

            "phone" => array(
                [0] => 
                [1] => "41 3333 4444"
            ),

            "city" => array(
                [0] => 
                [1] => "Curitiba"
            ),

            "state" => array(
                [0] => 
                [1] => "Parana"
            ),

            "country" => array(
                [0] => 
                [1] => "Brazil"
            )
        ),

        "lastname" => array(
            [0] => 
            [1] => "Silva"
        ),

        "position" => array(
            [0] => 
            [1] => "2. Prospect"
        ),

        "email" => array(
            [0] =>  
            [1] => "teste@teste.com"
        ),

        "mobile" => array(
            [0] =>  
            [1] => "41 9 9999 9999"
        ),

        "phone" => array(
            [0] => 
            [1] => "41 3333 4444"
        ),

        "points" => array(
            [0] => 0
            [1] => 
        ),

        "city" => array(
            [0] => 
            [1] => "Curitiba"
        ),

        "state" => array(
            [0] => 
            [1] => "Parana"
        ),

        "country" => array(
            [0] => 
            [1] => "Brazil"
        ),

        "dateIdentified" => array(
            [0] => 
            [1] => $datetime
        )
    );

    print_r($data);

?>