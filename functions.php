<?php
const TABLE_COL = 3;

$indexsArray = [
    [
        'name' => 'IMT',
        'formula' => function (int $height, int $mass) {
            return round($mass * 10000 / ($height ** 2), 2);
        }
    ],
    [
        'name' => 'Brok',
        'formula' => function (int $height) {
            return round($height - 100, 2);
        }
    ],
    [
        'name' => 'Breytman',
        'formula' => function (int $height) {
            return round($height * 0.7 - 50, 2);
        }
    ],
    [
        'name' => 'Berngard',
        'formula' => function (int $height, int $mass, int $chest) {
            return round($chest * $height / 240, 2);
        }
    ],
    [
        'name' => 'Davenport',
        'formula' => function (int $height, int $mass) {
            return round($mass * 1000 / ($height ** 2), 2);
        }
    ],
    [
        'name' => 'Noorden',
        'formula' => function (int $height) {
            return round($height * 0.42, 2);
        }
    ],
    [
        'name' => 'Tatony',
        'formula' => function (int $height) {
            return round($height - 100 - ($height - 100) / 20, 2);
        }
    ]
];

function readGuys() : array
{
    $guys = [];
    $row = 0;
    if (($file = fopen('guys.csv', 'r')) !== false) {
        while (($line = fgetcsv($file, 1000, ',')) !== false) {
            for ($i = 0; $i < TABLE_COL; $i++) {
                if ($i === 0) {
                    $guys[$row]['mass'] = $line[$i];
                } elseif ($i === 1) {
                    $guys[$row]['height'] = $line[$i];
                } else {
                    $guys[$row]['chest'] = $line[$i];
                }
            }
            $row++;
        }
        fclose($file);
    }

    return $guys;
}

function readArgv(array $argv) : array
{
    $row = 0;
    $guys = [];
    for ($i = 1; $i < count($argv); $i++) {
        if (($i % TABLE_COL) === 1) {
            $guys[$row]['mass'] = $argv[$i];
        } elseif (($i % TABLE_COL) === 2) {
            $guys[$row]['height'] = $argv[$i];
        } else {
            $guys[$row]['chest'] = $argv[$i];
        }
        if (($i % TABLE_COL) === 0) {
            $row++;
        }
    }

    return ['guys' => $guys, 'row' => $row];
}

function addTableHeaders(array $indexsArray, int $line) : array
{
    $resultArray[$line] = ['Mass', 'Height', 'Chest'];
    foreach ($indexsArray as $indexBodyMass) {
        array_push($resultArray[$line], 
        $indexBodyMass['name'], 
        $indexBodyMass['name'] . ' norm');
    }

    return $resultArray;
}

function showIndex(string $name, float $index, int $mass)
{
    $norm = norm($name, $index, $mass);
    echo "Index $name: $index, Norm $name: $norm \n";
}

function writeIndexToResultArray(string $name, float $index, int $mass, array $resultArray, int $line) : array
{
    $norm = norm($name, $index, $mass);

    $resultArray[$line][$name] = $index;
    $resultArray[$line]['Norm ' . $name] = $norm;

    return $resultArray;
}

function norm(string $name, float $index, int $mass) : string
{
    if ($name === 'IMT') {
        $norm = normIndexBodyMass($index);
    } elseif ($name === 'Davenport') {
        $norm = normDavenport($index);
    } else {
        $norm = normOther($index, $mass);
    }
    return $norm;
}

function normOther(float $index, int $mass) : string
{
    if ((($index - 15) > $mass) || (($index + 15) < $mass)) {
        return '-';
    } else {
        return '+';
    }
}

function normIndexBodyMass(float $index) : string
{
    switch ($index) {
        case ($index <= 16):
            return 'Выраженный дефицит';
            break;
        case ($index <= 18.5):
            return 'Дефицит';
            break;
        case ($index <= 25):
            return 'Норма';
            break;
        case ($index <= 30):
            return 'Избыточная';
            break;
        case ($index <= 35):
            return 'Ожирение';
            break;
        case ($index <= 40):
            return 'Резкое ожирение';
            break;
        case ($index > 40):
            return 'Очень резкое ожирение';
            break;
        default:
            return 'Неправильное значение';
            break;
    }
}

function normDavenport(float $index) : string
{
    if (($index > 3) || ($index < 1)) {
        return '-';
    } else {
        return '+';
    }
}

function checkArguments($arguments) : array
{
    for ($i = 1; $i < count($arguments); $i++) {
        if ((float)$arguments[$i] == 0) {
            echo "Введите ненулевое число \n";
            return ['guys' => [], 'err' => true];
        }
    }

    $returnedArray = readArgv($arguments);
    $guys = $returnedArray['guys'];
    $row = $returnedArray['row'];

    if ((count($arguments) - 1) % TABLE_COL === 1) {
        echo "Введите свои рост и окружность грудной клетки.\n";
        unset($guys[$row]);
    } elseif ((count($arguments) - 1) % TABLE_COL === 2) {
        echo "Введите свою окружность грудной клетки.\n";   
        unset($guys[$row]);
    }

    return ['guys' => $guys, 'err' => false];
}

function validSubmit(array $resultArray) : bool
{
    foreach($resultArray as $arg) {
        if ($arg > 0) {
            return false;
        }
        return true;
    }
}
