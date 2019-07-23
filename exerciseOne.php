<?php
    declare(strict_types = 1);
    require_once 'functions.php';

    $guys = readGuys();

    foreach ($guys as $guy) {
        $mass = $guy['mass'];
        $height = $guy['height'];
        $chest = $guy['chest'];
        echo "Mass: $mass, Height: $height, Chest circumference: $chest \n";
        foreach ($indexsArray as $name) {
            createIndex($name, round($name((int)$height, (int)$mass, (int)$chest), 2), (int)$mass);
        }
    }
?>