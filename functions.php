<?php

function initIndexs() : array
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

function readCsv(string $path) : array
{
    $array = [];
    if (($file = fopen($path, 'r')) !== false) {
        $line = fgetcsv($file, 1000, ',');
        $heads = $line;
        for ($i = 0; $i < sizeof(file($path)) - 1; $i++) {
            $line = fgetcsv($file, 1000, ',');
            $array[$i] = array_combine($heads, $line);
        }
        fclose($file);
    }
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
            echo "Enter nonzero positive numbers. \n";

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
        echo "Enter your mass, height and chest circumference. \n";
    } elseif (((count($arguments)) % count($heads)) === 1) {
        echo "Enter your height and chest circumference. \n";
        unset($array[$lineCounts]);
    } elseif (((count($arguments)) % count($heads)) === 2) {
        echo "Enter your chest circumference. \n";
        unset($array[$lineCounts]);
    } else {
        echo "Something went wrong. \n";
    }
    echo "Numbers of lines $lineCounts \n";

    return $array;
}

function getResultArray(array $array, bool $headers) : array
{
    $indexsArray = initIndexs();
    $resultArray = [];
    $line = 0;
    
    foreach ($array as $item) {
        $columns = array_keys(reset($array));
        for ($i = 0; $i < count($columns); $i++) {
            $resultArray[$line][$columns[$i]] = $item[$columns[$i]];
        }

        $mass = (float)$item['mass'];
        $height = (float)$item['height'];
        $chest = (float)$item['chest'];

        foreach ($indexsArray as $indexItem) {
            $resultArray = setIndex(
                $indexItem['name'], 
                $indexItem['formula']($height, $mass, $chest), 
                $mass, $resultArray, $line);
        }
        $line++;
    }

    if (($headers) && (!empty($resultArray))){
        $arrayKeys = array_keys(reset($resultArray));
        $head = [];
        foreach ($arrayKeys as $key) {
            $head[] = $key;
        }
        array_unshift($resultArray, $head);
    }
    return $resultArray;
}

function setIndex(string $name, float $index, float $mass, array $resultArray, int $line) : array
{
    $norm = getNorm($name, $index, $mass);

    $resultArray[$line][$name] = $index;
    $resultArray[$line]['Norm ' . $name] = $norm;

    return $resultArray;
}

function validSubmit(array $resultArray) : bool
{
    foreach ($resultArray as $arg) {
        if ($arg <= 0) {
            return false;
        }
    }

    return true;
}

function writeCsv(array $resultArray)
{
    $result = fopen("result.csv", "w+");
    foreach ($resultArray as $line) {
        fputcsv($result, $line);
    }
    fclose($result);
}

function uploadFile(string $fileName, string $fileTmpPath) : string
{
    $filePath = './uploaded_files/' . $fileName;
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
            return 'Severe deficiency';
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
            return 'Severe obesity';
            break;
        case ($index > 40):
            return 'Very severe obesity';
            break;
        default:
            return 'Incorrect value';
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