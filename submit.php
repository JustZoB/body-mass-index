<?php
require_once 'functions.php';
$result = fopen("result.csv", "w+");
$resultArray = addTableHeaders($indexsArray, 0);
$guysCount = 1;

$resultArray[$guysCount] =
    [
        'mass' => $_POST['mass'],
        'height' => $_POST['height'],
        'chest' => $_POST['chest']
    ];

foreach ($indexsArray as $indexBodyMass) {
    $resultArray = writeIndexToResultArray(
        $indexBodyMass['name'],
        $indexBodyMass['formula'](
            (int)$_POST['height'],
            (int)$_POST['mass'],
            (int)$_POST['chest']),
        (int)$_POST['mass'],
        $resultArray,
        $guysCount);
}
foreach ($resultArray as $resultArrayString) {
    fputcsv($result, $resultArrayString);
}
fclose($result);
