<?php
    declare(strict_types = 1);
    require_once 'functions.php';
    $guys = readFile();

    foreach ($guys as $guy) {
        $mass = $guy[0];
        $height = $guy[1];
        $chest = $guy[2];
        echo "Mass: $mass, Height: $height, Chest circumference: $chest \n";
        createIndex('IMT', round($mass * 10000 / ($height ** 2) , 2), (int)$mass);
        createIndex('Brok', round($height - 100, 2), (int)$mass);
        createIndex('Breytman', round($height * 0.7 - 50, 2), (int)$mass);
        createIndex('Berngard', round($chest * $height / 240, 2), (int)$mass);
        createIndex('Davenport', round($mass * 1000 / (($height ** 2)), 2), (int)$mass);
        createIndex('Noorden', round($height * 0.42, 2), (int)$mass);
        createIndex('Tatony', round($height - 100 - ($height - 100) / 20, 2), (int)$mass);
    }
?>

