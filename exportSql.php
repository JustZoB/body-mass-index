<?php
declare (strict_types=1);
require_once 'functions.php';
require_once 'sqlFunctions.php';

$result = sqlExport('indexs');
$columnName = array_keys(reset($result));
array_unshift($result, $columnName);

$file_path = 'uploaded_files/result.csv';
$file = fopen($file_path, 'w+');
if ($file !== false) {
    foreach ($result as $line) {
        fputcsv($file, $line);
    }
} else {
    echo 'Error: can\'t open file ' . $file_path;
}

fclose($file);

array_unshift($result, $file_path);
echo json_encode($result);
