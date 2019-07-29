<?php
require_once 'functions.php';

$result = fopen("result.csv", "w+");
$resultArray = addTableHeaders($indexsArray, 0);
$line = 1;

$resultArray[$line] = [
    'mass' => (float)$_POST['mass'],
    'height' => (float)$_POST['height'],
    'chest' => (float)$_POST['chest']
];

if (validSubmit($resultArray)) {
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
}

foreach ($resultArray as $resultArrayString) {
    fputcsv($result, $resultArrayString);
}
fclose($result);

return $resultArray;
