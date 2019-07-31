<?php
declare (strict_types=1);
require_once 'functions.php';

$resultArray = addHeaders();
if (count($argv) > 1) {
    if (validArgv($argv)) {
        $people = checkArgv($argv);
    }
} else {
    $people = readPeople('people.csv');
}
$resultArray = peopleToArray($people, $resultArray);
arrayToCsv($resultArray);