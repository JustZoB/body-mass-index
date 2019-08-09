<?php
const DIR = 'uploaded_files/';

function sqlImportIndexes(array $array)
{
    $link = connect();
    foreach ($array as $item) {
        mysqli_query($link, insert('indexs', implode(",", array_keys(reset($array))), getData($item)));
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
    return sprintf("'%s'", $str);
}

function getFile(array $array, string $delimiter = ',') : string
{
    $file_path = DIR . uniqid('file_', true) . '.csv';
    if (writeInFile($file_path, $array)) {
        return 'Error: can\'t open file ' . $file_path;
    }

    return $file_path;
}

function writeInFile(string $file_path, array $array, string $delimiter = ',') : bool
{
    $file = fopen($file_path, 'w+');
    if ($file === false) {
        echo 'Error: can\'t open file ' . $file_path;

        return false;
    }
    foreach ($array as $line) {
        fputcsv($file, $line, $delimiter);
    }
    fclose($file);

    return true;
}

function insert(string $name, string $columns, string $data) : string
{
    return 'INSERT INTO ' . $name . ' (' . $columns . ') VALUES(' . $data . ');';
}

function getData(array $array) : string
{
    $str = '';
    foreach ($array as $item) {
        if (gettype($item) == 'string') {
            $item = sprintf("'%s',", $item);
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

function connect() : mysqli
{
    $config = getConfig();

    return mysqli_connect($config['port'], $config['user'], $config['password'], $config['database']);
}

function getConfig() : array
{
    return require 'config.php';
}
