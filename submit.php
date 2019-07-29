<?php
require_once 'functions.php';

$result = fopen("result.csv", "w+");
$resultArray = addTableHeaders($indexsArray, 0);
$line = 1;

$resultArray[$line] = [
    'mass' => $_POST['mass'],
    'height' => $_POST['height'],
    'chest' => $_POST['chest']
];

foreach ($indexsArray as $index) {
    $resultArray = writeIndexToResultArray(
        $index['name'],
        $index['formula'](
            (int)$_POST['height'],
            (int)$_POST['mass'],
            (int)$_POST['chest']),
        (int)$_POST['mass'],
        $resultArray,
        $line);
}
foreach ($resultArray as $resultArrayString) {
    fputcsv($result, $resultArrayString);
}
fclose($result);

return $resultArray;
