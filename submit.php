<?php
require_once 'functions.php';

$resultArray = addTableHeaders();

if (isset($_POST['mass'], $_POST['height'], $_POST['chest'])) {
    if (validSubmit([(float)$_POST['mass'], (float)$_POST['height'], (float)$_POST['chest']])) {
        $people[] = [
            'mass' => (float)$_POST['mass'],
            'height' => (float)$_POST['height'],
            'chest' => (float)$_POST['chest']
        ];
        $resultArray = arrayOfPeopleToResultArray($people, $resultArray);
    }   
}

resultArrayToResultCsvFile($resultArray);