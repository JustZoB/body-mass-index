<?php
declare (strict_types=1);
require_once 'functions.php';
require_once 'sqlFunctions.php';

$result = getDatabase('indexs');
$columnName = array_keys(reset($result));
array_unshift($result, $columnName);

$file_path = 'uploaded_files/result.csv';
if (!writeInFile($file_path, $result)) {
    echo 'Error can\'t open file ' . $file_path;
} else {
    $result[] = $file_path;

    echo json_encode($result);
}
