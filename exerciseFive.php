<?php
declare (strict_types=1);
require_once 'functions.php';

if (count($argv) > 1) {
    if (validArgv($argv)) {
        $people = getArgv($argv);
    }
} else {
    $people = readCsv('people.csv');
}
writeCsv(getResult($people, true));
