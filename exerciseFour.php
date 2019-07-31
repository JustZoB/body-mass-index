<?php
declare (strict_types=1);
require_once 'functions.php';

if (validArgv($argv)) {
    arrayToCsv(peopleToArray(checkArgv($argv), true));
}
