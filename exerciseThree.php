<?php
declare (strict_types=1);
require_once 'functions.php';

$resultArray = addHeaders();
$resultArray = peopleToArray(readPeople('people.csv'), $resultArray);
arrayToCsv($resultArray);