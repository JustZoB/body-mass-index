<?php
declare (strict_types=1);
require_once 'functions.php';
writeCsv(getResult(readCsv('people.csv'), true));
