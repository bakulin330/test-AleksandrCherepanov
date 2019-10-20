#!/usr/bin/env bash

chmod -R 777 /app
cd /app
composer install
echo "Container was built"
tail -f /dev/null