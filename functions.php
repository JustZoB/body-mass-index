<?php
const TABLE_COL = 3;

function arrayOfIndexs() : array {
    return $indexsArray = [
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

function readPeople($path) : array
{
    $people = [];
    $row = 0;
    if (($file = fopen($path, 'r')) !== false) {
        while (($line = fgetcsv($file, 1000, ',')) !== false) {
            for ($i = 0; $i < TABLE_COL; $i++) {
                if ($i === 0) {
                    $people[$row]['mass'] = $line[$i];
                } elseif ($i === 1) {
                    $people[$row]['height'] = $line[$i];
                } else {
                    $people[$row]['chest'] = $line[$i];
                }
            }
            $row++;
        }
        fclose($file);
    }

    return $people;
}

function readArgv(array $argv) : array
{
    $row = 0;
    $people = [];
    for ($i = 1; $i < count($argv); $i++) {
        if (($i % TABLE_COL) === 1) {
            $people[$row]['mass'] = $argv[$i];
        } elseif (($i % TABLE_COL) === 2) {
            $people[$row]['height'] = $argv[$i];
        } else {
            $people[$row]['chest'] = $argv[$i];
        }
        if (($i % TABLE_COL) === 0) {
            $row++;
        }
    }

    return ['people' => $people, 'row' => $row];
}

function addHeaders() : array
{
    $indexsArray = arrayOfIndexs();
    $resultArray = [];
    $resultArray[0] = ['Mass', 'Height', 'Chest'];
    foreach ($indexsArray as $indexBodyMass) {
        array_push($resultArray[0], 
        $indexBodyMass['name'], 
        $indexBodyMass['name'] . ' norm');
    }

    return $resultArray;
}

function writeInFile($result, array $resultArray) {
    foreach ($resultArray as $resultArrayString) {
        fputcsv($result, $resultArrayString);
    }
}



function validArgv($arguments) : bool
{
    for ($i = 1; $i < count($arguments); $i++) {
        if ((float)$arguments[$i] == 0) {
            echo "Enter nonzero positive numbers. \n";
            return false;
        }
    }

    return true;
}

function checkArgv($arguments) : array
{
    $arrayArgv = readArgv($arguments);
    $people = $arrayArgv['people'];
    $row = $arrayArgv['row'];

    if (count($arguments) === 1) {
        echo "Enter your mass, height and chest circumference. \n";
    } elseif (((count($arguments) - 1) % TABLE_COL) === 1) {
        echo "Enter your height and chest circumference. \n";
        unset($people[$row]);
    } elseif (((count($arguments) - 1) % TABLE_COL) === 2) {
        echo "Enter your chest circumference. \n";
        unset($people[$row]);
    }

    return $people;
}

function peopleToConsole(array $people)
{
    $indexsArray = arrayOfIndexs();
    foreach ($people as $human) {
        echo "Mass: " . $human['mass'] . ", Height: " . $human['height'] . ", Chest circumference: " . $human['chest'] . "\n";
        foreach ($indexsArray as $indexMT) {
            showIndex($indexMT['name'], $indexMT['formula']((int)$human['height'],
                (int)$human['mass'], (int)$human['chest']), (int)$human['mass']);
        }
    }
}

function showIndex(string $name, float $index, float $mass)
{
    $norm = norm($name, $index, $mass);
    echo "Index $name: $index, Norm $name: $norm \n";
}

function peopleToArray(array $people, array $resultArray) : array
{
    $indexsArray = arrayOfIndexs();
    $line = 1;
    foreach ($people as $human) {
        $resultArray[$line] = ['mass' => $human['mass'], 'height' => $human['height'], 'chest' => $human['chest']];

        foreach ($indexsArray as $indexMT) {
            $resultArray = indexesToArray(
                $indexMT['name'], 
                $indexMT['formula']((float)$human['height'], (float)$human['mass'], (float)$human['chest']), 
                (float)$human['mass'], 
                $resultArray,
                $line);
        }
        $line++;
    }
    return $resultArray;
}

function indexesToArray(string $name, float $index, float $mass, array $resultArray, int $line) : array
{
    $norm = norm($name, $index, $mass);

    $resultArray[$line][$name] = $index;
    $resultArray[$line]['Norm ' . $name] = $norm;

    return $resultArray;
}


function norm(string $name, float $index, float $mass) : string
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

function normOther(float $index, float $mass) : string
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
            return 'Severe deficiency';
            break;
        case ($index <= 18.5):
            return 'Deficiency';
            break;
        case ($index <= 25):
            return 'Norm';
            break;
        case ($index <= 30):
            return 'Избыточная';
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

function normDavenport(float $index) : string
{
    if (($index > 3) || ($index < 1)) {
        return '-';
    } else {
        return '+';
    }
}

function validSubmit(array $resultArray) : bool
{
    foreach($resultArray as $arg) {
        if ($arg <= 0) {
            return false;
        }
    }

    return true;
}

function arrayToCsv(array $resultArray) 
{
    $result = fopen("result.csv", "w+");
    writeInFile($result, $resultArray);
    fclose($result);
}