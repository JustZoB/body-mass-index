<?php
require_once 'functions.php';
require_once 'sqlFunctions.php';

if ((isset($_POST['mass'], $_POST['height'], $_POST['chest'])) && (validSubmit([$_POST['mass'], $_POST['height'], $_POST['chest']]))) {
    $human[] = [
        'mass' => (float)$_POST['mass'],
        'height' => (float)$_POST['height'],
        'chest' => (float)$_POST['chest']
    ];
    $array = getResult($human, true);
    writeCsv($array, 'result.csv');
    sqlImportIndexs($array);
    echo json_encode($array);
}
