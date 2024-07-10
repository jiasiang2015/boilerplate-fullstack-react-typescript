#!/bin/bash -x

set -e

BUILD_FOLDER=${1}
NEW_VERSION=${2}
SSH_DOMAIN=${3}
SSH_KEY_PATH=${4}

PREVIOUS_VERSION=$((NEW_VERSION - 1))

printf "\n\n\n"
printf "=====================================================\n"
printf "UPDATE WITH NEW VERSION: v0.0.$NEW_VERSION\n"
printf "COPY v0.0.$PREVIOUS_VERSION env file to v0.0.$NEW_VERSION\n\n"

ssh $SSH_DOMAIN -i $SSH_KEY_PATH << EOF

printf "\n\n"
printf "cd to the Build Folder\n"
cd /opt/$BUILD_FOLDER

printf "\n\n"
printf "Copy Env File\n"
sudo cp v0.0.$PREVIOUS_VERSION/.env v0.0.$NEW_VERSION/.env

printf "\n\n"
printf "cd to the Version Folder\n"
cd v0.0.$NEW_VERSION

printf "\n\n"
printf "Update Env App Version for v0.0.$NEW_VERSION\n"
sudo sed -i "s/APP_VERSION=v0.0.$PREVIOUS_VERSION/APP_VERSION=v0.0.$NEW_VERSION/g" .env
EOF

