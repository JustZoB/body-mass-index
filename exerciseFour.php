<?php
declare (strict_types=1);
require_once 'functions.php';

$resultArray = addTableHeaders();
if (validArgv($argv)) {
    $resultArray = arrayOfPeopleToResultArray(checkArgv($argv), $resultArray);
}
resultArrayToResultCsvFile($resultArray);