<?php
declare (strict_types=1);
require_once 'functions.php';

if (validArgv($argv)) {
    $resultArray = peopleToArray(checkArgv($argv), true);
}
arrayToCsv($resultArray);