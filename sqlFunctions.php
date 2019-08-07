<?php
const DIR = 'uploaded_files/';

function sqlImportIndexs(array $array)
{
    $link = connect();
    $columnName = implode(',', $array[0]);

    if (count($array) === 2) {
        mysqli_query($link, insertIndexs($columnName, $array[1]));
    } else {
        array_shift($array);
        foreach ($array as $item) {
            mysqli_query($link, insertIndexs($columnName, $item));
        }
    }
    mysqli_close($link);
}

function sqlImportFiles(array $array, string $fileSource) : string
{
    $link = connect();
    $fileResult = getFile($array);
    mysqli_query($link, insertFiles(formatToString($fileSource), formatToString($fileResult)));
    mysqli_close($link);

    return $fileResult;
}

function formatToString(string $str) : string
{
    return '\'' . $str . '\'';
}

function getFile(array $array) : string
{
    $file_path = DIR . uniqid('file_', true) . '.csv';
    if ($file = fopen($file_path, 'w+')) {
        foreach ($array as $line) {
            fputcsv($file, $line);
        }
    } else {
        echo 'Error: can\'t open file ' . $file_path;
    }
    fclose($file);

    return $file_path;
}

function insertFiles(string $fileSource, string $fileResult) : string
{
    return 'INSERT INTO files (source, result) VALUES(' . $fileSource . ',' . $fileResult . ');';
}

function insertIndexs(string $columnName, array $user) : string
{
    $str = '';
    foreach ($user as $item) {
        if (gettype($item) == 'string') {
            $item = sprintf('\'%s\',', $item);
        } else {
            $item .= ',';
        }
        $str .= $item;
    }
    $str = substr($str, 0, -1);

    return 'INSERT INTO indexs (' . $columnName . ') VALUES(' . $str . ');';
}

function sqlExport($table) : array
{
    $link = connect();
    $data = select($link, $table);
    mysqli_close($link);

    return $data;
}

function select($link, $table) : array
{
    $result = mysqli_query($link, 'SELECT DISTINCT * FROM ' . $table);
    for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row) {
        ;
    }

    return $data;
}

function getConfig() : array
{
    return require_once 'config.php';
}

function connect()
{
    $config = getConfig();

    return mysqli_connect('127.0.0.1', 'justzob', 'ei7veeChu4bo', 'ibm');
}
