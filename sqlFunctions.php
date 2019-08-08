<?php
const DIR = 'uploaded_files/';

function sqlImportIndexs(array $array)
{
    $link = connect();
    $columnName = implode(',', $array[0]);

    if (count($array) === 2) {
        mysqli_query($link, insert('indexs', $columnName, getData($array[1])));
    } else {
        array_shift($array);
        foreach ($array as $item) {
            mysqli_query($link, insert('indexs', $columnName, getData($item)));
        }
    }
    mysqli_close($link);
}

function sqlImportFiles(array $array, string $fileSource, string $columnsName) : string
{
    $link = connect();
    $fileResult = getFile($array);
    mysqli_query($link, insert('files', $columnsName, formatToString($fileSource) . ',' . formatToString($fileResult)));
    mysqli_close($link);

    return $fileResult;
}

function formatToString(string $str) : string
{
    return sprintf("\'%s\'", $str);
}

function getFile(array $array) : string
{
    $file_path = DIR . uniqid('file_', true) . '.csv';
    $file = fopen($file_path, 'w+');
    if ($file === false) {
        echo 'Error: can\'t open file ' . $file_path;
        
        return $file_path;
    }

    foreach ($array as $line) {
        fputcsv($file, $line);
    }
    fclose($file);

    return $file_path;
}

function insert(string $name, string $columns, string $data) : string 
{
    return 'INSERT INTO' . $name . '( ' . $columns . ') VALUES(' . $data . ');';
}

function getData(array $array) : string
{
    $str = '';
    foreach ($array as $item) {
        if (gettype($item) == 'string') {
            $item = sprintf('\'%s\',', $item);
        } else {
            $item .= ',';
        }
        $str .= $item;
    }

    return substr($str, 0, -1);
}

function getDatabase(string $table) : array
{
    $link = connect();
    $data = select($link, $table);
    mysqli_close($link);

    return $data;
}

function select(mysqli $link, string $table) : array
{
    $result = mysqli_query($link, 'SELECT DISTINCT * FROM ' . $table);
    for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row);

    return $data;
}

function getConfig() : array
{
    return require 'config.php';
}

function connect()
{
    $config = getConfig();

    return mysqli_connect($config['port'], $config['user'], $config['password'], $config['database']);
}
