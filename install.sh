#!/usr/bin/env bash

set -e

echo "=================================="
echo "      Hetzner Shop Installer"
echo "=================================="

read -p "Bot Token: " BOT_TOKEN
read -p "Admin ID: " ADMIN_ID
read -p "Hetzner API Token: " HETZNER_TOKEN

read -p "Database Host [localhost]: " DB_HOST
DB_HOST=${DB_HOST:-localhost}

read -p "Database Name: " DB_NAME
read -p "Database User: " DB_USER
read -s -p "Database Password: " DB_PASS
echo

cat > .env <<EOF
BOT_TOKEN=$BOT_TOKEN
ADMIN_ID=$ADMIN_ID
HETZNER_TOKEN=$HETZNER_TOKEN

DB_HOST=$DB_HOST
DB_NAME=$DB_NAME
DB_USER=$DB_USER
DB_PASS=$DB_PASS
EOF

echo "Installing packages..."

if command -v apt >/dev/null 2>&1; then
    apt update
    apt install -y php php-cli php-mysql php-curl php-mbstring unzip curl git
fi

if [ -f composer.json ]; then
    php -r "copy('https://getcomposer.org/installer','composer-setup.php');"
    php composer-setup.php
    php composer.phar install --no-dev
    rm composer-setup.php
fi

chmod -R 755 .

echo
echo "Installation completed successfully."
echo
echo "Run your bot normally."
