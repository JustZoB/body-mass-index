<?php
declare (strict_types=1);
require_once 'functions.php';

$people = [];

$result = fopen("result.csv", "w+");
$resultArray = addTableHeaders($indexsArray);
$line = 1;

$err = false;
for ($i = 1; $i < count($argv); $i++) {
    if ((float)$argv[$i] == 0) {
        echo "Введите ненулевое число \n";
        $err = true;
    }
}
if (!$err) {
    $returnedArray = readArgv($argv);
    $people = $returnedArray['people'];
    $row = $returnedArray['row'];

    if (count($argv) === 1) {
        echo "Enter your mass, height and chest circumference. \n";
    } elseif (((count($argv) - 1) % TABLE_COL) === 1) {
        echo "Enter your свои height and chest circumference. \n";
        unset($people[$row]);
    } elseif (((count($argv) - 1) % TABLE_COL) === 2) {
        echo "Enter your chest circumference. \n";
        unset($people[$row]);
    }

    foreach ($people as $human) {
        $resultArray[$line] = ['mass' => $human['mass'], 'height' => $human['height'], 'chest' => $human['chest']];

        foreach ($indexsArray as $indexBodyMass) {
            $resultArray = writeIndexToResultArray($indexBodyMass['name'],
                $indexBodyMass['formula']((int)$human['height'], (int)$human['mass'], (int)$human['chest']),
                (int)$human['mass'], $resultArray, $line);
        }
        $line++;
    }
}

writeInFile($result, $resultArray);
fclose($result);
