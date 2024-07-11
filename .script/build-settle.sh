#!/bin/bash -x

# ====================================================================
# =======              幫 unzip 的檔案做設定                    =======
set -e

# 顏色 Color
COLOR_LBULE='\033[1;34m'
COLOR_LGREEN='\033[1;32m'
COLOR_LPURPLE='\033[1;35m'
COLOR_NONE='\033[0m' # No Color


BUILD_FOLDER=${1}
NEW_VERSION=${2}
SSH_DOMAIN=${3}
SSH_KEY_PATH=${4}

PREVIOUS_VERSION=$((NEW_VERSION - 1))

# 設置新的版本，設定 ENV、權限
printf "\n\n\n"
printf "${COLOR_LBULE} ====================================================================       ${COLOR_NONE}\n"
printf "${COLOR_LBULE} UPDATE WITH NEW VERSION: ${COLOR_LBULE}[v0.0.$NEW_VERSION]                 ${COLOR_NONE}\n"
printf "${COLOR_LBULE} COPY ${COLOR_LGREEN}[v0.0.$PREVIOUS_VERSION env file to v0.0.$NEW_VERSION] ${COLOR_NONE}\n\n"

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

printf "\n\n"
printf "Execute Permission in v0.0.$NEW_VERSION\n"
sudo chown -R $USER:www-data storage;
sudo chown -R $USER:www-data bootstrap/cache;
sudo chmod -R 2775 storage;
sudo chmod -R 2775 bootstrap/cache

printf "\n\n"
printf "Execute Laravel Command in v0.0.$PREVIOUS_VERSION\n"
php artisan storage:link
EOF

