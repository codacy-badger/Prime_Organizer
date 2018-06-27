<?php
    $text = 'a:11:{s:5:"owner";a:2:{i:0;N;i:1;i:1;}s:9:"firstname";a:2:{i:0;N;i:1;s:6:"Fulano";}s:6:"fields";a:7:{s:9:"firstname";a:2:{i:0;N;i:1;s:6:"Fulano";}s:8:"lastname";a:2:{i:0;N;i:1;s:6:"de tal";}s:8:"position";a:2:{i:0;N;i:1;s:8:"ANALISTA";}s:5:"email";a:2:{i:0;N;i:1;s:18:"teste@teste.com.br";}s:5:"phone";a:2:{i:0;N;i:1;s:12:"41 3333 3333";}s:4:"city";a:2:{i:0;N;i:1;s:8:"Curitiba";}s:5:"state";a:2:{i:0;N;i:1;s:6:"Parana";}}s:8:"lastname";a:2:{i:0;N;i:1;s:6:"de tal";}s:8:"position";a:2:{i:0;N;i:1;s:8:"ANALISTA";}s:5:"email";a:2:{i:0;N;i:1;s:18:"teste@teste.com.br";}s:5:"phone";a:2:{i:0;N;i:1;s:12:"41 3333 3333";}s:6:"points";a:2:{i:0;i:0;i:1;N;}s:4:"city";a:2:{i:0;N;i:1;s:8:"Curitiba";}s:5:"state";a:2:{i:0;N;i:1;s:6:"Parana";}s:14:"dateIdentified";a:2:{i:0;s:0:"";i:1;O:8:"DateTime":3:{s:4:"date";s:26:"2018-06-25 18:31:10.000000";s:13:"timezone_type";i:3;s:8:"timezone";s:3:"UTC";}}}';
    var_dump(unserialize($text));
    
    $datetime = new DateTime();
    $datetime -> format('Y-m-d H:i:s');

    $data = array(
        "owner" => array(
            [0] => NULL, 
            [1] => 1
        ),

        'firstname' => array(
            [0] => NULL,
            [1] => 'Rodrigo'
        ),

        'fields' => array(
            'firstname' => array(
                [0] => NULL,
                [1] => 'Rodrigo'
            ),

            'lastname' => array(
                [0] => NULL,
                [1] => 'Silva'
            ),

            'position' => array(
                [0] => NULL,
                [1] => '2. Prospect'
            ),

            'email' => array(
                [0] => NULL,
                [1] => 'teste@teste.com'
            ),

            'mobile' => array(
                [0] => NULL,
                [1] => '41 9 9999 9999'
            ),

            'phone' => array(
                [0] => NULL,
                [1] => '41 3333 4444'
            ),

            'city' => array(
                [0] => NULL,
                [1] => 'Curitiba'
            ),

            'state' => array(
                [0] => NULL,
                [1] => 'Parana'
            ),

            'country' => array(
                [0] => NULL,
                [1] => 'Brazil'
            )
        ),

        'lastname' => array(
            [0] => NULL,
            [1] => 'Silva'
        ),

        'position' => array(
            [0] => NULL,
            [1] => '2. Prospect'
        ),

        'email' => array(
            [0] => NULL,
            [1] => 'teste@teste.com'
        ),

        'mobile' => array(
            [0] => NULL,
            [1] => '41 9 9999 9999'
        ),

        'phone' => array(
            [0] => NULL,
            [1] => '41 3333 4444'
        ),

        'points' => array(
            [0] => 0,
            [1] => NULL
        ),

        'city' => array(
            [0] => NULL,
            [1] => 'Curitiba'
        ),

        'state' => array(
            [0] => NULL,
            [1] => 'Parana'
        ),

        'country' => array(
            [0] => NULL,
            [1] => 'Brazil'
        ),

        'dateIdentified' => array(
            [0] => (string)'',
            [1] => $datetime
        )
    );

    var_dump($data);

?>