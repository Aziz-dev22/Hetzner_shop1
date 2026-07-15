<?php

if (!file_exists(__DIR__ . '/.env')) {
    die("Please run install.sh first.\n");
}

$env = parse_ini_file(__DIR__ . '/.env', false, INI_SCANNER_RAW);

define('BOT_TOKEN', $env['BOT_TOKEN']);
define('ADMIN_ID', $env['ADMIN_ID']);
define('HETZNER_TOKEN', $env['HETZNER_TOKEN']);

define('DB_HOST', $env['DB_HOST']);
define('DB_NAME', $env['DB_NAME']);
define('DB_USER', $env['DB_USER']);
define('DB_PASS', $env['DB_PASS']);

define('DOMAIN', $env['DOMAIN']);
