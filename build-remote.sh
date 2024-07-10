#!/bin/bash -x

set -e

BUILD_FOLDER=${1}
NEW_VERSION=${2}
SSH_DOMAIN=${3}
SSH_KEY_PATH=${4}


printf "\n\n"
printf "=====================================================\n"
printf "GET NEW_VERSION: v0.0.$NEW_VERSION\n"

printf "\n\n"
printf "=====================================================\n"
printf "CREATE FOLDER\n"

ssh $SSH_DOMAIN -i $SSH_KEY_PATH << EOF

printf "\n\n"
printf "CD to the folder\n"
cd /opt/$BUILD_FOLDER

printf "\n\n"
printf "Make new folder\n"
sudo mkdir v0.0.$NEW_VERSION

sudo chmod 777 v0.0.$NEW_VERSION
EOF

printf "\n\n"
printf "=====================================================\n"
printf "COPY FILE TO SERVER\n"

scp -i $SSH_KEY_PATH ./output/v0.0.$NEW_VERSION.zip $SSH_DOMAIN:/opt/$BUILD_FOLDER/v0.0.$NEW_VERSION


printf "\n\n"
printf "=====================================================\n"
printf "UNPACKING ZIP AND SETTINGS\n"

ssh $SSH_DOMAIN -i $SSH_KEY_PATH << EOF

cd /opt/$BUILD_FOLDER/v0.0.$NEW_VERSION
unzip v0.0.$NEW_VERSION

cd ..
ln -sfn v0.0.$NEW_VERSION latest

EOF
