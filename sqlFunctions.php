<?php
const PORT = "127.0.0.1";
const USER = "justzob";
const PASSWORD = "ei7veeChu4bo";
const DATABASE = "ibm";

function sqlImport(array $array) 
{
    $link = connect();
    $columnName = implode(',', $array[0]);
    
    if (count($array) === 2) {
        mysqli_query($link, insert($columnName, $array[1]));
    } else {
        array_shift($array);
        foreach($array as $item) {
            mysqli_query($link, insert($columnName, $item));
        }
    }
    mysqli_close($link);
}

function sqlExport() : array
{
    $link = connect();
    $data = select($link);
    mysqli_close($link);

    return $data;
}

function connect()
{
    return mysqli_connect(PORT, USER, PASSWORD, DATABASE);
}

function select($link) : array
{
    $result = mysqli_query($link, "SELECT DISTINCT * FROM indexs");
    for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row);

    return $data;
}

function insert(string $columnName, array $user) : string
{
    $str = "";
    foreach ($user as $item) {
        if (gettype($item) == 'string') {
            sprintf('%s%s%s', '\'', $item, '\'');
        } else {
            sprintf('%s%s', $item, '\'');
        }
        $str .= $item;
    }
    $str = substr($str, 0, -1);
    return 'INSERT INTO indexs (' . $columnName . ') VALUES(' . $str . ');';
}