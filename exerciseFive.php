<?php
declare (strict_types=1);
require_once 'functions.php';

$result = fopen("result.csv", "w+");
$resultArray = addTableHeaders($indexsArray);
$line = 1;

$err = false;
if (count($argv) > 1) {
    $returnedArray = checkArguments($argv);
    $people = $returnedArray['people'];
    $err = $returnedArray['err'];
} else {
    $people = readPeople();
}

if (!$err) {
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
