<?php
declare (strict_types = 1);
require_once 'functions.php';

$result = fopen("result.csv", "w+");
$guysCount = 0;
$resultArray = addTableHeaders($indexsArray, $guysCount);
$guysCount++;

$err = false;
if (count($argv) > 1) {
    for ($i = 1; $i < count($argv); $i++) {
        if ((float) $argv[$i] === 0) {
            echo "Введите ненулевое число";
            $err = true;
        }
    }
    if (!$err) {
        $guys = [];
        $guys = readARGV($argv)['guys'];
        $row = readARGV($argv)['row'];

        if ((count($argv) - 1) % TABLE_COL === 1) {
            echo "Введите свои рост и окружность грудной клетки.\n";
            unset($guys[$row]);
        } elseif ((count($argv) - 1) % TABLE_COL === 2) {
            echo "Введите свою окружность грудной клетки.\n";
            unset($guys[$row]);
        }
    }
} else {
    $guys = readGuys();
}

foreach ($guys as $guy) {
    $resultArray[$guysCount] = [ 'mass' => $guy['mass'], 'height' => $guy['height'], 'chest' => $guy['chest']];

    foreach ($indexsArray as $indexBodyMass) {
        $resultArray = writeIndexToResultArray($indexBodyMass['name'], 
        $indexBodyMass['formula']((int) $guy['height'], (int) $guy['mass'], (int) $guy['chest']), 
        (int) $guy['mass'], $resultArray, $guysCount);
    }

    $guysCount++;
}

foreach ($resultArray as $resultArrayString) {
    fputcsv($result, $resultArrayString);
}
fclose($result);
