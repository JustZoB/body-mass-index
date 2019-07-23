<?php
declare (strict_types = 1);
require_once 'functions.php';

$result = fopen("result.csv", "w+");
$guyscount = 0;
$resultArray = addHeaders($indexsArray, $guyscount);
$guyscount++;
foreach (readGuys() as $guy) {
    $resultArray[$guyscount]['mass'] = $guy['mass'];
    $resultArray[$guyscount]['height'] = $guy['height'];
    $resultArray[$guyscount]['chest'] = $guy['chest'];

    foreach ($indexsArray as $indexMT) {
        $resultArray = writeIndexToResultArray($indexMT['name'], 
        $indexMT['formula']((int) $guy['height'], (int) $guy['mass'], (int) $guy['chest']), 
        (int) $guy['mass'], $resultArray, $guyscount);
    }
    $guyscount++;
}

foreach ($resultArray as $resultArrayString) {
    fputcsv($result, $resultArrayString);
}
fclose($result);
