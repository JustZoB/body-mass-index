<?php
declare (strict_types=1);
require_once 'functions.php';
require_once 'sqlFunctions.php';

$result = sqlExport();
$heads = array_keys($result[0]);
array_unshift($result, $heads);

$file_path = 'uploaded_files/result.csv';
$file = fopen($file_path, 'w+');
foreach ($result as $line) {
    fputcsv($file, $line);  
}
fclose($file);

array_unshift($result, $file_path);
echo json_encode($result);
