<?php
declare (strict_types=1);
require_once 'functions.php';
require_once 'sqlFunctions.php';
const UPLOAD_DIR = '/uploaded_files/';

$filePath = dirname(__FILE__) . UPLOAD_DIR;
if (isset($_FILES['file'])) {
    $extension_file = mb_strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));
    $file_name = uniqid('file_', true) . '.' . $extension_file;
    $full_unique_name = $filePath . $file_name;
    $file = UPLOAD_DIR . $file_name;

    move_uploaded_file($_FILES['file']['tmp_name'], $full_unique_name);
    $filePath = uploadFile($_FILES['file']['name'], $_FILES['file']['tmp_name']);
    $array = getResult(readCsv($full_unique_name), true);

    writeCsv($array);
    sqlImportIndexs($array);
    $fileResult = sqlImportFiles($array, $file);

    array_unshift($array, $fileResult);
    array_unshift($array, $file);

    echo json_encode($array);
} else {
    echo 'Error: Can\'t open this file';
}
