<?php
    declare(strict_types = 1);
    require_once 'functions.php';

    foreach (readGuys() as $guy) {
        $mass = $guy['mass'];
        $height = $guy['height'];
        $chest = $guy['chest'];
        echo "Mass: $mass, Height: $height, Chest circumference: $chest \n";
        foreach ($indexsArray as $indexMT) {
            createIndex($indexMT['name'], $indexMT['formula']((int)$height, (int)$mass, (int)$chest), (int)$mass);
        }
    }
?>