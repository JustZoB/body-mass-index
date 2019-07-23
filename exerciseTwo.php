<?php
    declare(strict_types = 1);
    require_once 'functions.php';

    $guys = readGuys();
    
    $result = fopen("result.csv", "w+");
    $guyscount = 0;
    $resultArray = [];    

    foreach ($guys as $guy) {
        $resultArray[$guyscount]['mass'] = $mass = $guy['mass'];
        $resultArray[$guyscount]['height'] = $height = $guy['height'];
        $resultArray[$guyscount]['chest'] = $chest = $guy['chest'];

        foreach ($indexsArray as $name) {
            createIndexCSV($name, round($name((int)$height, (int)$mass, (int)$chest), 2), (int)$mass);
        }

        $guyscount++;
    }
    
    foreach ($resultArray as $resultArrayString) {
        fputcsv($result, $resultArrayString);
    }
    fclose($result);
?>