<?php
require_once 'functions.php';

$result = fopen("result.csv", "w+");
$resultArray = addTableHeaders($indexsArray, 0);
$line = 1;
if (isset($_POST['mass'], $_POST['height'], $_POST['chest'])) {
    if (validSubmit([(float)$_POST['mass'], (float)$_POST['height'], (float)$_POST['chest']])) {
        $resultArray[$line] = [
            'mass' => (float)$_POST['mass'],
            'height' => (float)$_POST['height'],
            'chest' => (float)$_POST['chest']
        ];
    
        foreach ($indexsArray as $index) {
            $resultArray = writeIndexToResultArray(
                $index['name'],
                $index['formula'](
                    (int)$_POST['height'],
                    (int)$_POST['mass'],
                    (int)$_POST['chest']),
                (int)$_POST['mass'],
                $resultArray,
                $line);
        }
    }   
}

foreach ($resultArray as $resultArrayString) {
    fputcsv($result, $resultArrayString);
}
fclose($result);

return $resultArray;
