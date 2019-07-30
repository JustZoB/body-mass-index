<?php
declare (strict_types=1);
require_once 'functions.php';

$resultArray = addTableHeaders();
$resultArray = arrayOfPeopleToResultArray(readPeople(), $resultArray);
resultArrayToResultCsvFile($resultArray);