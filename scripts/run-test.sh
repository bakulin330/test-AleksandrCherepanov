#!/usr/bin/env bash

docker exec -t mottor.local /bin/bash -c "php ./vendor/phpunit/phpunit/phpunit ./tests"