<?php
declare (strict_types=1);
require_once 'functions.php';

if (validArgv($argv)) {
    writeCsv(getResultArray(getArgv($argv), true));
}
