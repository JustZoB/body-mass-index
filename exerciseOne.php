<?php
declare (strict_types=1);
require_once 'functions.php';

foreach (readGuys() as $guy) {
    echo "Mass: " . $guy['mass'] . ", Height: " . $guy['height'] . ", Chest circumference: " . $guy['chest'] . "\n";
    foreach ($indexsArray as $indexMT) {
        showIndex($indexMT['name'], $indexMT['formula']((int)$guy['height'],
            (int)$guy['mass'], (int)$guy['chest']), (int)$guy['mass']);
    }
}
