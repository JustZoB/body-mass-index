<?php
declare (strict_types = 1);
require_once 'functions.php';

$guys = [];

$resultArray = addHeaders($indexsArray, $guyscount);
$guyscount++;

$err = false;
for ($i = 1; $i < count($argv); $i++) {
    if ((float) $argv[$i] == 0) {
        echo "Введите ненулевое число \n";
        $err = true;
    }
}
if (!$err) {
    $guys = readARGV($argv)['guys'];
    $row = readARGV($argv)['row'];

    if (count($argv) == 1) {
        echo "Введите свои массу, рост и окружность грудной клетки. \n";
    } elseif ((count($argv) - 1) % TABLE_COL == 1) {
        echo "Введите свои рост и окружность грудной клетки. \n";
        unset($guys[$row]);
    } elseif ((count($argv) - 1) % TABLE_COL == 2) {
        echo "Введите свою окружность грудной клетки. \n";
        unset($guys[$row]);
    }

    foreach ($guys as $guy) {
        $resultArray[$guyscount]['mass'] = $mass = $guy['mass'];
        $resultArray[$guyscount]['height'] = $height = $guy['height'];
        $resultArray[$guyscount]['chest'] = $chest = $guy['chest'];

        foreach ($indexsArray as $indexMT) {
            $resultArray = createIndexCSV($indexMT['name'], $indexMT['formula']((int) $height, (int) $mass, (int) $chest), (int) $mass, $resultArray, $guyscount);
        }
        $guyscount++;
    }
}

foreach ($resultArray as $resultArrayString) {
    fputcsv($result, $resultArrayString);
}
fclose($result);
