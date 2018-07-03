<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "teste_organizer";

    // Create connection
    $org = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($org->connect_error) {
        die("Connection failed: " . $org->connect_error);
    }

    $org -> set_charset('utf8_unicode_ci');
?>