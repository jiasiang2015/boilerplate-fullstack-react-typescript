#!/bin/bash -x

# ====================================================================
# =======        用於連線到 ssh 將檔案複製到遠端伺服器            =======
# =======            解壓縮檔案，並設定連結                      =======


# 顏色 Color
COLOR_LBULE='\033[1;34m'
COLOR_LGREEN='\033[1;32m'
COLOR_LPURPLE='\033[1;35m'
COLOR_NONE='\033[0m' # No Color

set -e

BUILD_FOLDER=${1}
NEW_VERSION=${2}
SSH_DOMAIN=${3}
SSH_KEY_PATH=${4}


printf "\n\n"
printf "${COLOR_LBULE} =====================================================\n ${COLOR_NONE}"
printf "${COLOR_LBULE} GET NEW_VERSION: ${COLOR_LGREEN}[v0.0.$NEW_VERSION] \n ${COLOR_NONE}"

# 建立新的資料夾
printf "\n\n"
printf "${COLOR_LBULE} =====================================================\n ${COLOR_NONE}"
printf "${COLOR_LBULE} CREATE FOLDER\n ${COLOR_LGREEN}[/opt/$BUILD_FOLDER/v0.0.$NEW_VERSION] \n ${COLOR_NONE} "

ssh $SSH_DOMAIN -i $SSH_KEY_PATH << EOF

printf "\n\n"
printf "CD to the folder\n"
cd /opt/$BUILD_FOLDER

printf "\n\n"
printf "Make new folder\n"
sudo mkdir v0.0.$NEW_VERSION

sudo chmod 777 v0.0.$NEW_VERSION
EOF


# 將檔案複製到遠端伺服器
printf "\n\n"
printf "${COLOR_LBULE} =====================================================\n ${COLOR_NONE}"
printf "${COLOR_LBULE} COPY FILE ${COLOR_LGREEN} [./output/v0.0.$NEW_VERSION.zip] ${COLOR_LBULE} TO SERVER\n ${COLOR_NONE}"

scp -i $SSH_KEY_PATH ./output/v0.0.$NEW_VERSION.zip $SSH_DOMAIN:/opt/$BUILD_FOLDER/v0.0.$NEW_VERSION


# 解壓縮檔案，並設定連結
printf "\n\n"
printf "${COLOR_LBULE} =====================================================\n ${COLOR_NONE}"
printf "${COLOR_LBULE} UNPACKING ZIP AND SETTINGS\n ${COLOR_NONE}"

ssh $SSH_DOMAIN -i $SSH_KEY_PATH << EOF

cd /opt/$BUILD_FOLDER/v0.0.$NEW_VERSION
unzip -qq v0.0.$NEW_VERSION

cd ..
ln -sfn v0.0.$NEW_VERSION latest

EOF
