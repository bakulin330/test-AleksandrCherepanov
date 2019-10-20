#!/usr/bin/env bash

ALLOWED_COMMANDS=('build', 'start', 'test')
COMMAND=$1
# Assuming it is project directory
CURRENT_DIRECTORY=$(pwd)

[[ -z ${COMMAND} ]] && COMMAND='build'

if ! [[ ${ALLOWED_COMMANDS[*]} =~ ${COMMAND} ]]
then
    echo "${COMMAND} is not allowed"
    echo "Allowed commands are:"
    echo "  build - build container"
    echo "  start - run application in container"
    echo "  test - run tests in container"
    exit 1
fi

echo "Executing..."
CURRENT_DIRECTORY=${CURRENT_DIRECTORY} sh ./scripts/run-${COMMAND}.sh