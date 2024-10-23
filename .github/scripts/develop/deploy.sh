#!/bin/bash -x

# 顏色 Color
COLOR_LBULE='\033[1;34m'
COLOR_LGREEN='\033[1;32m'
COLOR_LPURPLE='\033[1;35m'
COLOR_NONE='\033[0m' # No Color

set -e

BUILD_FOLDER=${1}
NEW_VERSION=${2}

print_color() {
    local color=$1
    local message=$2
    printf "${color}${message}${COLOR_NONE} \n"
}

# 建立新的資料夾
print_color "${COLOR_LBULE}" "===================================================================="
print_color "${COLOR_LBULE}" "GET NEW_VERSION: ${COLOR_LGREEN}[v0.0.$NEW_VERSION], CREATE FOLDER:  ${COLOR_LGREEN}[/opt/$BUILD_FOLDER/v0.0.$NEW_VERSION] \n"


print_color "${COLOR_LPURPLE}" "Create the folder and Permission setting \n"
mkdir -p -m 755 /opt/$BUILD_FOLDER/v0.0.$NEW_VERSION


# 將檔案複製到目標目錄
print_color "${COLOR_LBULE}" "--------------------------------------------------------------------"
print_color "${COLOR_LBULE}" "COPY FILE ${COLOR_LGREEN} [.<runner>/v0.0.$NEW_VERSION.zip] ${COLOR_LBULE} TO /opt/$BUILD_FOLDER/v0.0.$NEW_VERSION \n"

cp ./v0.0.$NEW_VERSION.zip /opt/$BUILD_FOLDER/v0.0.$NEW_VERSION


# 解壓縮檔案，並設定連結
print_color "${COLOR_LBULE}" "--------------------------------------------------------------------"
print_color "${COLOR_LBULE}" "UNPACKING ZIP AND SETTINGS"


cd /opt/$BUILD_FOLDER/v0.0.$NEW_VERSION
unzip -qq v0.0.$NEW_VERSION

cd ..
ln -sfn v0.0.$NEW_VERSION latest
