<?php
    declare(strict_types = 1);
    require_once 'functions.php';

    $result = fopen("result.csv", "w+");
    $guyscount = 0;
    $resultArray = [];    

    foreach (readGuys() as $guy) {
        $resultArray[$guyscount]['mass'] = $mass = $guy['mass'];
        $resultArray[$guyscount]['height'] = $height = $guy['height'];
        $resultArray[$guyscount]['chest'] = $chest = $guy['chest'];

        foreach ($indexsArray as $indexMT) {
            $resultArray = createIndexCSV($indexMT['name'], $indexMT['formula']((int)$height, (int)$mass, (int)$chest), (int)$mass, $resultArray, $guyscount);
        }
        $guyscount++;
    }
    
    foreach ($resultArray as $resultArrayString) {
        fputcsv($result, $resultArrayString);
    }
    fclose($result);
?>