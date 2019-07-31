<?php
declare (strict_types=1);
require_once 'functions.php';

$resultArray = peopleToArray(readPeople('people.csv'), false);
arrayToCsv($resultArray);