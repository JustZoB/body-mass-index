<?php
declare (strict_types=1);
require_once 'functions.php';

$guys = [];

$result = fopen("result.csv", "w+");
$guysCount = 0;
$resultArray = addTableHeaders($indexsArray, $guysCount);
$guysCount++;

$err = false;
for ($i = 1; $i < count($argv); $i++) {
    if ((float)$argv[$i] == 0) {
        echo "Введите ненулевое число \n";
        $err = true;
    }
}
if (!$err) {
    $returnedArray = readArgv($argv);
    $guys = $returnedArray['guys'];
    $row = $returnedArray['row'];

    if (count($argv) === 1) {
        echo "Введите свои массу, рост и окружность грудной клетки. \n";
    } elseif ((count($argv) - 1) % TABLE_COL === 1) {
        echo "Введите свои рост и окружность грудной клетки. \n";
        unset($guys[$row]);
    } elseif ((count($argv) - 1) % TABLE_COL === 2) {
        echo "Введите свою окружность грудной клетки. \n";
        unset($guys[$row]);
    }

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
