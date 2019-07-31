<?php
declare (strict_types=1);
require_once 'functions.php';
writeCsv(getResultArray(readCsv('people.csv'), false));
