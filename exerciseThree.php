<?php
declare (strict_types = 1);
require_once 'functions.php';

$result = fopen("result.csv", "w+");
$guysCount = 0;
$resultArray = addTableHeaders($indexsArray, $guysCount);
$guysCount++;
foreach (readGuys() as $guy) {
    $resultArray[$guysCount]['mass'] = $guy['mass'];
    $resultArray[$guysCount]['height'] = $guy['height'];
    $resultArray[$guysCount]['chest'] = $guy['chest'];

    foreach ($indexsArray as $indexMT) {
        $resultArray = writeIndexToResultArray($indexMT['name'], 
        $indexMT['formula']((int) $guy['height'], (int) $guy['mass'], (int) $guy['chest']), 
        (int) $guy['mass'], $resultArray, $guysCount);
    }
    $guysCount++;
}

foreach ($resultArray as $resultArrayString) {
    fputcsv($result, $resultArrayString);
}
fclose($result);
