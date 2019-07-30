<?php
declare (strict_types=1);
require_once 'functions.php';

$result = fopen("result.csv", "w+");
$line = 0;
$resultArray = [];
var_dump($result);
foreach (readGuys() as $guy) {
    $resultArray[$line] = ['mass' => $guy['mass'], 'height' => $guy['height'], 'chest' => $guy['chest']];

    foreach ($indexsArray as $indexMT) {
        $resultArray = writeIndexToResultArray($indexMT['name'],
            $indexMT['formula']((int)$guy['height'], (int)$guy['mass'], (int)$guy['chest']),
            (int)$guy['mass'], $resultArray, $line);
    }
    $line++;
}

writeInFile($result, $resultArray);
fclose($result);
