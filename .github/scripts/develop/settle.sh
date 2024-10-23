#!/bin/bash -x

set -e

# 顏色 Color
COLOR_LBULE='\033[1;34m'
COLOR_LGREEN='\033[1;32m'
COLOR_LPURPLE='\033[1;35m'
COLOR_NONE='\033[0m' # No Color


BUILD_FOLDER=${1}
NEW_VERSION=${2}

PREVIOUS_VERSION=$((NEW_VERSION - 1))

print_color() {
    local color=$1
    local message=$2
    printf "${color}${message}${COLOR_NONE} \n"
}

# 設置新的版本，設定 ENV、權限
print_color "${COLOR_LBULE}" "===================================================================="
print_color "${COLOR_LBULE}" "UPDATE WITH NEW VERSION: ${COLOR_LBULE}[v0.0.$NEW_VERSION]"
print_color "${COLOR_LBULE}" "COPY ${COLOR_LGREEN}[v0.0.$PREVIOUS_VERSION env file to v0.0.$NEW_VERSION] \n"


print_color "${COLOR_LPURPLE}" "cd to the Build Folder\n"
cd /opt/$BUILD_FOLDER


print_color "${COLOR_LPURPLE}" "Copy Env File\n"
cp v0.0.$PREVIOUS_VERSION/.env v0.0.$NEW_VERSION/.env


print_color "${COLOR_LPURPLE}" "cd to the Version Folder\n"
cd v0.0.$NEW_VERSION


print_color "${COLOR_LPURPLE}" "Update Env App Version for v0.0.$NEW_VERSION\n"
sed -i "s/APP_VERSION=v0.0.$PREVIOUS_VERSION/APP_VERSION=v0.0.$NEW_VERSION/g" .env


print_color "${COLOR_LPURPLE}" "Execute Permission in v0.0.$NEW_VERSION\n"
sudo chown -R $USER:www-data storage;
sudo chown -R $USER:www-data bootstrap/cache;
sudo chmod -R 2775 storage;
sudo chmod -R 2775 bootstrap/cache
php artisan storage:link

# print_color "${COLOR_LPURPLE}" "EFS Link Resources\n"
# cd /opt/$BUILD_FOLDER/v0.0.$NEW_VERSION/public/storage
# ln -s /opt/efs/$BUILD_FOLDER resources

# print_color "${COLOR_LPURPLE}" "Restart Supervisor\n"
# sudo service supervisor restart



