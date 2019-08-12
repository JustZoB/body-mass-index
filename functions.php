<?php
const UPLOAD_DIR = '/uploaded_files/';

function getIndexes() : array
{
    return [
        [
            'name' => 'IMT',
            'formula' => function (float $height, float $mass) {
                return round($mass * 10000 / ($height ** 2), 2);
            }
        ],
        [
            'name' => 'Brok',
            'formula' => function (float $height) {
                return round($height - 100, 2);
            }
        ],
        [
            'name' => 'Breytman',
            'formula' => function (float $height) {
                return round($height * 0.7 - 50, 2);
            }
        ],
        [
            'name' => 'Berngard',
            'formula' => function (float $height, float $mass, float $chest) {
                return round($chest * $height / 240, 2);
            }
        ],
        [
            'name' => 'Davenport',
            'formula' => function (float $height, float $mass) {
                return round($mass * 1000 / ($height ** 2), 2);
            }
        ],
        [
            'name' => 'Noorden',
            'formula' => function (float $height) {
                return round($height * 0.42, 2);
            }
        ],
        [
            'name' => 'Tatony',
            'formula' => function (float $height) {
                return round($height - 100 - ($height - 100) / 20, 2);
            }
        ]
    ];
}

function csvToArray(string $path, string $delimiter = ',') : array
{
    $array = [];
    $file = fopen($path, 'r');
    if ($file === false) {
        echo 'Error: cant open file ' . $path;
        
        return $array;
    }
    $heads = fgetcsv($file, 1000, $delimiter);

    for ($i = 0; $i < sizeof(file($path)) - 1; $i++) {
        $array[$i] = array_combine($heads, fgetcsv($file, 1000, $delimiter));
    }
    fclose($file);

    return $array;
}

function readArgv(array $argv, array $heads) : array
{
    $row = 0;
    $array = [];
    for ($i = 0; $i < count($argv); $i++) {
        $elem = ($i) % count($heads);
        $array[$row][$heads[$elem]] = $argv[$i];
        if ($elem === count($heads) - 1) {
            $row++;
        }
    }

    return ['rows' => $array, 'lineCounts' => $row];
}

function validArgv(array $arguments) : bool
{
    for ($i = 1; $i < count($arguments); $i++) {
        if ((float)$arguments[$i] == 0) {
            echo 'Enter nonzero positive numbers.' . PHP_EOL;

            return false;
        }
    }

    return true;
}

function getArgv(array $arguments) : array
{
    array_shift($arguments);
    $heads = ['mass', 'height', 'chest'];

    $arrayArgv = readArgv($arguments, $heads);
    $array = $arrayArgv['rows'];
    $lineCounts = $arrayArgv['lineCounts'];

    if (count($arguments) === 0) {
        echo 'Enter your mass, height and chest circumference.' . PHP_EOL;
    } elseif (((count($arguments)) % count($heads)) === 1) {
        echo 'Enter your height and chest circumference.' . PHP_EOL;
        unset($array[$lineCounts]);
    } elseif (((count($arguments)) % count($heads)) === 2) {
        echo 'Enter your chest circumference.' . PHP_EOL;
        unset($array[$lineCounts]);
    } else {
        echo 'Something went wrong.' . PHP_EOL;
    }
    echo 'Numbers of lines ' . $lineCounts . PHP_EOL;

    return $array;
}

function getResult(array $array) : array
{
    $indexesArray = getIndexes();
    $resultArray = [];

    foreach ($array as $i => $item) {
        $columnsName = array_keys(reset($array));
        foreach ($columnsName as $name) {
            $resultArray[$i][$name] = $item[$name];
        }
        foreach ($indexesArray as $indexItem) {
            $index = $indexItem['formula']($item['height'], $item['mass'], $item['chest']);

            $resultArray[$i][$indexItem['name']] = $index;
            $resultArray[$i]['Norm_' . $indexItem['name']] = getNorm($indexItem['name'], $index, $item['mass']); 
        }
    }

    return $resultArray;
}

function validSubmit(array $resultArray) : bool
{
    foreach ($resultArray as $arg) {
        if (!is_numeric($arg)) {
            return false;
        }
    }

    return true;
}

function arrayToCsv(array $resultArray, string $file_name, bool $headers = false, string $delimiter = ',')
{
    $result = fopen($file_name, 'w+');
    if ($result !== false) {
        if (($headers) && (!empty($resultArray))) {
            $arrayKeys = array_keys(reset($resultArray));
            $head = [];
            foreach ($arrayKeys as $key) {
                $head[] = $key;
            }
            fputcsv($result, $head, $delimiter);
        }
        foreach ($resultArray as $line) {
            fputcsv($result, $line, $delimiter);
        }
    } else {
        echo 'Error: cant open file result.csv';
    }
    fclose($result);
}

function uploadFile(string $fileName, string $fileTmpPath) : string
{
    $filePath = '.' . UPLOAD_DIR . $fileName;
    move_uploaded_file($fileTmpPath, $filePath);

    return $filePath;
}

function getNorm(string $name, float $index, float $mass) : string
{
    if ($name === 'IMT') {
        $norm = getNormIndexBodyMass($index);
    } elseif ($name === 'Davenport') {
        $norm = getNormDavenport($index);
    } else {
        $norm = getNormOther($index, $mass);
    }

    return $norm;
}

function getNormOther(float $index, float $mass) : string
{
    if ((($index - 15) > $mass) || (($index + 15) < $mass)) {
        return '-';
    } else {
        return '+';
    }
}

function getNormIndexBodyMass(float $index) : string
{
    switch ($index) {
        case ($index <= 16):
            return 'Severe_deficiency';
            break;
        case ($index <= 18.5):
            return 'Deficiency';
            break;
        case ($index <= 25):
            return 'Norm';
            break;
        case ($index <= 30):
            return 'Overweight';
            break;
        case ($index <= 35):
            return 'Obesity';
            break;
        case ($index <= 40):
            return 'Severe_obesity';
            break;
        case ($index > 40):
            return 'Very severe_obesity';
            break;
        default:
            return 'Incorrect_value';
            break;
    }
}

function getNormDavenport(float $index) : string
{
    if (($index > 3) || ($index < 1)) {
        return '-';
    } else {
        return '+';
    }
}
