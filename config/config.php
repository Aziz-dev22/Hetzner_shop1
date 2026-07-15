<?php

/**
 * Hetzner Shop Configuration
 * Version 1.0
 */


if (!file_exists(__DIR__ . '/../.env')) {

    die(
        "Environment file not found. Run installer first."
    );

}


$env = parse_ini_file(
    __DIR__ . '/../.env',
    false,
    INI_SCANNER_RAW
);


if ($env === false) {

    die(
        "Cannot read environment file."
    );

}



/*
|--------------------------------------------------------------------------
| Database
|--------------------------------------------------------------------------
*/

define(
    'DB_HOST',
    $env['DB_HOST'] ?? 'localhost'
);

define(
    'DB_NAME',
    $env['DB_NAME'] ?? ''
);

define(
    'DB_USER',
    $env['DB_USER'] ?? ''
);

define(
    'DB_PASS',
    $env['DB_PASS'] ?? ''
);



/*
|--------------------------------------------------------------------------
| Telegram
|--------------------------------------------------------------------------
*/

define(
    'BOT_TOKEN',
    $env['BOT_TOKEN'] ?? ''
);


define(
    'ADMIN_ID',
    $env['ADMIN_ID'] ?? ''
);



/*
|--------------------------------------------------------------------------
| Hetzner
|--------------------------------------------------------------------------
*/

define(
    'HETZNER_TOKEN',
    $env['HETZNER_TOKEN'] ?? ''
);



/*
|--------------------------------------------------------------------------
| Website
|--------------------------------------------------------------------------
*/

define(
    'DOMAIN',
    $env['DOMAIN'] ?? ''
);



/*
|--------------------------------------------------------------------------
| Payment
|--------------------------------------------------------------------------
*/

define(
    'EURO_PRICE',
    $env['EURO_PRICE'] ?? 75000
);



/*
|--------------------------------------------------------------------------
| Application
|--------------------------------------------------------------------------
*/

define(
    'APP_NAME',
    'Hetzner Shop'
);


define(
    'APP_VERSION',
    '1.0.0'
);


date_default_timezone_set(
    'Asia/Tehran'
);

define(
'USDT_BEP20_ADDRESS',
$env['USDT_BEP20_ADDRESS'] ?? ''
);


define(
'TRX_ADDRESS',
$env['TRX_ADDRESS'] ?? ''
);
