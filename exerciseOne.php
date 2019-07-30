<?php
declare (strict_types=1);
require_once 'functions.php';

foreach (readPeople() as $human) {
    echo "Mass: " . $human['mass'] . ", Height: " . $human['height'] . ", Chest circumference: " . $human['chest'] . "\n";
    foreach ($indexsArray as $indexMT) {
        showIndex($indexMT['name'], $indexMT['formula']((int)$human['height'],
            (int)$human['mass'], (int)$human['chest']), (int)$human['mass']);
    }
}
