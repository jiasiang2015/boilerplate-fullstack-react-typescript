#!/bin/bash -x

set -e

BUILD_FOLDER=${1}
SSH_DOMAIN=${2}
SSH_KEY_PATH=${3}
NEW_VERSION=${4}


printf "\n\n\n"
printf "=====================================================\n"
printf "GET NEW_VERSION: v0.0.$NEW_VERSION\n"

printf "\n\n\n"
printf "=====================================================\n"
printf "CREATE FOLDER\n"

ssh $SSH_DOMAIN -i $SSH_KEY_PATH << EOF

printf "\n\n\n"
printf "CD to the folder"
cd /opt/bill-test/

printf "\n\n\n"
printf "List All the Verison"
ls -a

printf "\n\n\n"
printf "Make new folder"
sudo mkdir v0.0.$NEW_VERSION

sudo chmod 777 v0.0.$NEW_VERSION
EOF

printf "\n\n\n"
printf "=====================================================\n"
printf "COPY FILE TO SERVER\n"

scp -i $SSH_KEY_PATH ./output/v0.0.$NEW_VERSION.zip $SSH_DOMAIN:/opt/bill-test/v0.0.$NEW_VERSION


printf "\n\n\n"
printf "=====================================================\n"
printf "UNPACKING ZIP AND SETTINGS\n"

ssh $SSH_DOMAIN -i $SSH_KEY_PATH << EOF

cd /opt/bill-test/v0.0.$NEW_VERSION
unzip v0.0.$NEW_VERSION


cd ..
ln -sfn v0.0.$NEW_VERSION latest
EOF

# echo ${{ secrets.STORE_FILE_BASE64 }} | base64 --decode > ${{ github.workspace }}/android/key.jks

# sudo chown -R $USER:www-data storage;
# sudo chown -R $USER:www-data bootstrap/cache;
# sudo chmod -R 2775 storage;
# sudo chmod -R 2775 bootstrap/cache