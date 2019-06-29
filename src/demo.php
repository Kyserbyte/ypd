<?php
require __DIR__ . '/../vendor/autoload.php';

use YPD\Demo\DemoJsonSerialize;

$d = new DemoJsonSerialize();

var_dump(json_encode($d));
