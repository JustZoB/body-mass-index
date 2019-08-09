<?php
declare (strict_types=1);
require_once 'functions.php';
require_once 'sqlFunctions.php';

$filePath = dirname(__FILE__) . UPLOAD_DIR;
if (isset($_FILES['file'])) {
    $extension_file = mb_strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));
    $file_name = uniqid('file_', true) . '.' . $extension_file;
    $full_unique_name = $filePath . $file_name;
    $file = UPLOAD_DIR . $file_name;

    move_uploaded_file($_FILES['file']['tmp_name'], $full_unique_name);
    $filePath = uploadFile($_FILES['file']['name'], $_FILES['file']['tmp_name']);
    if (isset($_FILES['delimitr'])) {
        $array = getResult(readCsv($full_unique_name, $_FILES['delimitr']));
    } else {
        $array = getResult(readCsv($full_unique_name, ','));
    }
    
    writeCsv($array, 'result.csv', true);
    sqlImportIndexes($array);
    $fileResult = sqlImportFiles($array, $file, 'source, result');

    array_unshift($array, array_keys(reset($array)));
    $array[] = $fileResult;
    $array[] = $file;

    echo json_encode($array);
} else {
    echo 'Error: Can\'t open this file';
}
