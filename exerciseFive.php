<?php
declare (strict_types=1);
require_once 'functions.php';

$result = fopen("result.csv", "w+");
$guysCount = 0;
$resultArray = addTableHeaders($indexsArray, $guysCount);
$guysCount++;

$err = false;
if (count($argv) > 1) {
    $returnedArray = checkArguments($argv);
    $guys = $returnedArray['guys'];
    $err = $returnedArray['err'];
} else {
    $guys = readGuys();
}

if (!$err) {
    foreach ($guys as $guy) {
        $resultArray[$guysCount] = ['mass' => $guy['mass'], 'height' => $guy['height'], 'chest' => $guy['chest']];

        foreach ($indexsArray as $indexBodyMass) {
            $resultArray = writeIndexToResultArray($indexBodyMass['name'],
                $indexBodyMass['formula']((int)$guy['height'], (int)$guy['mass'], (int)$guy['chest']),
                (int)$guy['mass'], $resultArray, $guysCount);
        }

        $guysCount++;
    }
}

foreach ($resultArray as $resultArrayString) {
    fputcsv($result, $resultArrayString);
}
fclose($result);
