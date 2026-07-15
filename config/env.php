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

        USDT_BEP20_ADDRESS=0x36c3061D61A7B615CC479CDA55d07EE2d927D831

TRX_ADDRESS=THKVkobSjCCU7WyWN5S8Z9q3kehvGKWYvN
    
    }
}
