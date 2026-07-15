<?php

if (!file_exists(__DIR__ . '/../.env')) {
    die(".env file not found.\nRun install.sh first.");
}

$env = parse_ini_file(__DIR__ . '/../.env', false, INI_SCANNER_RAW);

if ($env === false) {
    die("Unable to load .env file.");
}

foreach ($env as $key => $value) {
    if (!defined($key)) {
        define($key, trim($value));
    }
}
