<?php
declare (strict_types=1);
require_once 'functions.php';

$result = fopen("result.csv", "w+");
$resultArray = addTableHeaders($indexsArray, 0);
$line = 1;

foreach (readGuys() as $guy) {
    $resultArray[$line] = ['mass' => $guy['mass'], 'height' => $guy['height'], 'chest' => $guy['chest']];

    foreach ($indexsArray as $indexMT) {
        $resultArray = writeIndexToResultArray($indexMT['name'],
            $indexMT['formula']((int)$guy['height'], (int)$guy['mass'], (int)$guy['chest']),
            (int)$guy['mass'], $resultArray, $line);
    }
    $line++;
}

foreach ($resultArray as $resultArrayString) {
    fputcsv($result, $resultArrayString);
}
fclose($result);
