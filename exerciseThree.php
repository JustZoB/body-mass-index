<?php
declare (strict_types=1);
require_once 'functions.php';

$result = fopen("result.csv", "w+");
$resultArray = addTableHeaders($indexsArray);
$line = 1;

foreach (readPeople() as $human) {
    $resultArray[$line] = ['mass' => $human['mass'], 'height' => $human['height'], 'chest' => $human['chest']];

    foreach ($indexsArray as $indexMT) {
        $resultArray = writeIndexToResultArray($indexMT['name'],
            $indexMT['formula']((int)$human['height'], (int)$human['mass'], (int)$human['chest']),
            (int)$human['mass'], $resultArray, $line);
    }
    $line++;
}

writeInFile($result, $resultArray);
fclose($result);
