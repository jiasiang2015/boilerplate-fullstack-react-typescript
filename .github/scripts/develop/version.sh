#!/bin/bash -x
set -e

BUILD_FOLDER=${1}

cd /opt/$BUILD_FOLDER

VERSIONS=$(ls | grep -o 'v0\.0\.[0-9]\+')

LARGEST_VERSION=$(echo $VERSIONS | tr ' ' '\n' | sort -V | tail -n 1 | cut -d '.' -f 3)

NEW_VERSION=$((LARGEST_VERSION + 1))

echo $NEW_VERSION
