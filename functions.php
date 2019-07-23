<?php
const TABLE_COL = 3;
$result = fopen("result.csv", "w+");
$guyscount = 0;

$indexsArray = [
    ['name' => 'IMT',
        'formula' => function (int $height, int $mass) {return round($mass * 10000 / ($height ** 2), 2);}],
    ['name' => 'Brok',
        'formula' => function (int $height) {return round($height - 100, 2);}],
    ['name' => 'Breytman',
        'formula' => function (int $height) {return round($height * 0.7 - 50, 2);}],
    ['name' => 'Berngard',
        'formula' => function (int $height, int $mass, int $chest) {return round($chest * $height / 240, 2);}],
    ['name' => 'Davenport',
        'formula' => function (int $height, int $mass) {return round($mass * 1000 / ($height ** 2), 2);}],
    ['name' => 'Noorden',
        'formula' => function (int $height) {return round($height * 0.42, 2);}],
    ['name' => 'Tatony',
        'formula' => function (int $height) {return round($height - 100 - ($height - 100) / 20, 2);}]];

function readGuys(): array
{
    $guys = [];
    $row = 0;
    $file = [];
    if (($file = fopen('guys.csv', 'r')) !== false) {
        while (($line = fgetcsv($file, 1000, ',')) !== false) {
            for ($i = 0; $i < TABLE_COL; $i++) {
                if ($i == 0) {
                    $guys[$row]['mass'] = $line[$i];
                } elseif ($i == 1) {
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

function readARGV(array $argv): array
{
    $row = 0;
    $guys = [];
    for ($i = 1; $i < count($argv); $i++) {
        if ($i % TABLE_COL == 1) {
            $guys[$row]['mass'] = $argv[$i];
        } elseif ($i % TABLE_COL == 2) {
            $guys[$row]['height'] = $argv[$i];
        } else {
            $guys[$row]['chest'] = $argv[$i];
        }
        if ($i % TABLE_COL == 0) {
            $row++;
        }
    }

    return ['guys' => $guys, 'row' => $row];
}

function addHeaders(array $indexsArray, int $guyscount): array
{
    $resultArray[$guyscount] = ['Mass', 'Height', 'Chest'];
    foreach ($indexsArray as $indexMT) {
        $name = $indexMT['name'];
        $resultArray[$guyscount][] = "$name";
        $resultArray[$guyscount][] = "$name norm";
    }

    return $resultArray;
}

function createIndex(string $name, float $index, int $mass)
{
    $norm = norm($name, $index, $mass);
    echo "Index $name: $index, Norm $name: $norm \n";
}

function createIndexCSV(string $name, float $index, int $mass, array $resultArray, int $guyscount): array
{
    $norm = norm($name, $index, $mass);

    $resultArray[$guyscount]["$name"] = $index;
    $resultArray[$guyscount]["Norm $name"] = $norm;

    return $resultArray;
}

function norm(string $name, float $index, int $mass): string
{
    if ($name == 'IMT') {
        $norm = normIMT($index);
    } elseif ($name == 'Davenport') {
        $norm = normDavenport($index);
    } else {
        $norm = normOther($index, $mass);
    }
    return $norm;
}

function normOther(float $index, int $mass): string
{
    if ((($index - 15) > $mass) || (($index + 15) < $mass)) {
        return '-';
    } else {
        return '+';
    }
}

function normIMT(float $index): string
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
    }
}

function normDavenport(float $index): string
{
    if (($index > 3) or ($index < 1)) {
        return '-';
    } else {
        return '+';
    }
}
