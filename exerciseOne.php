<?php
declare (strict_types=1);
require_once 'functions.php';

writeTerminal(readCsv('people.csv'));

function writeTerminal(array $people)
{
    $indexsArray = initIndexs();
    foreach ($people as $human) {
        echo "Mass: " . $human['mass'] . ", Height: " . $human['height'] . ", Chest circumference: " . $human['chest'] . "\n";
        foreach ($indexsArray as $indexMT) {
            writeIndex($indexMT['name'], $indexMT['formula']((int)$human['height'],
                (int)$human['mass'], (int)$human['chest']), (int)$human['mass']);
        }
    }
}

function writeIndex(string $name, float $index, float $mass)
{
    $norm = getNorm($name, $index, $mass);
    echo "Index $name: $index, Norm $name: $norm \n";
}