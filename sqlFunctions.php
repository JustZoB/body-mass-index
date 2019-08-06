<?php

function sqlImport(array $array) 
{
    $link = mysqli_connect("127.0.0.1", "justzob", "ei7veeChu4bo", "ibm");
    $heads = implode(',', $array[0]);
    
    if (count($array) === 2) {
        mysqli_query($link, getQuery($heads, $array[1]));
    } else {
        array_shift($array);
        foreach($array as $item) {
            mysqli_query($link, getQuery($heads, $item));
        }
    }
}

function getQuery(string $heads, array $user) : string
{
    $str = "";
    foreach ($user as $item) {
        if (gettype($item) == 'string') {
            $item = '\'' . $item . '\',';
        } else {
            $item .= ',';    
        }
        $str .= $item;
    }
    $str = substr($str, 0, -1);
    return 'INSERT INTO indexs (' . $heads . ') VALUES(' . $str . ');';
}

function sqlExport() : array
{
    $link = mysqli_connect("127.0.0.1", "justzob", "ei7veeChu4bo", "ibm");
    $result = mysqli_query($link, "SELECT DISTINCT * FROM indexs");
    for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row);
    return $data;
}
