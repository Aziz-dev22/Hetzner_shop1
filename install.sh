#!/usr/bin/env bash

set -e

clear

echo "====================================="
echo "       Hetzner Shop Installer"
echo "            Version 1.0"
echo "====================================="

if [ "$EUID" -ne 0 ]; then
    echo "Please run as root"
    exit
fi


echo "[1/6] Installing requirements..."


apt update


apt install -y \
php \
php-cli \
php-curl \
php-mysqli \
php-mbstring \
curl \
git \
unzip \
composer



echo ""
echo "Enter Telegram Bot Token:"
read BOT_TOKEN


echo ""
echo "Enter Telegram Admin ID:"
read ADMIN_ID


echo ""
echo "Enter Hetzner API Token:"
read HETZNER_TOKEN


echo ""
echo "Database Host [localhost]:"
read DB_HOST

DB_HOST=${DB_HOST:-localhost}


echo ""
echo "Database Name:"
read DB_NAME


echo ""
echo "Database User:"
read DB_USER


echo ""
echo "Database Password:"
read DB_PASS


echo ""
echo "Website Domain:"
read DOMAIN



cat > .env <<EOF

BOT_TOKEN=$BOT_TOKEN

ADMIN_ID=$ADMIN_ID

HETZNER_TOKEN=$HETZNER_TOKEN


DB_HOST=$DB_HOST

DB_NAME=$DB_NAME

DB_USER=$DB_USER

DB_PASS=$DB_PASS


DOMAIN=$DOMAIN

EURO_PRICE=75000

EOF



echo "[2/6] Creating folders..."

mkdir -p storage/logs

mkdir -p storage/cache


chmod -R 755 storage



echo "[3/6] Installing composer packages..."


if [ -f composer.json ]
then
    composer install --no-dev
fi



echo "[4/6] Database setup..."



php -r "

\$mysqli = new mysqli(
'$DB_HOST',
'$DB_USER',
'$DB_PASS',
'$DB_NAME'
);

if(\$mysqli->connect_error){

echo 'Database error';

exit;

}

echo 'Database OK';

"



echo ""
echo "[5/6] Setting webhook..."



curl -s \
"https://api.telegram.org/bot${BOT_TOKEN}/setWebhook?url=${DOMAIN}/bot.php"



echo ""
echo ""
echo "[6/6] Completed!"

echo ""
echo "================================"
echo " Installation Finished "
echo "================================"

echo ""
echo "Bot Token saved."
echo "Admin ID saved."
echo "Configuration created."
