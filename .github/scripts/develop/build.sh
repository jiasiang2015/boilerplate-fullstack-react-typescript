#!/bin/bash -x

# 顏色 Color
COLOR_LBULE='\033[1;34m'
COLOR_LGREEN='\033[1;32m'
COLOR_LPURPLE='\033[1;35m'
COLOR_NONE='\033[0m' # No Color

set -e

VERSION=${1}
export COMPOSER_HOME="$HOME/.config/composer";

if [[ "${1}" == "" ]]; then
    echo "Missing version argument"
    exit 1
fi

print_color() {
    local color=$1
    local message=$2
    printf "${color}${message}${COLOR_NONE} \n"
}

print_color "${COLOR_LBULE}" "===================================================================="
print_color "${COLOR_LBULE}" "INSTALL NEW_VERSION DEPENDENCIES: ${COLOR_LGREEN}[v0.0.$NEW_VERSION]\n"

# 建立新的資料夾
print_color "${COLOR_LPURPLE}" "Install Composer Packages \n"
composer install -n --prefer-dist --optimize-autoloader --quiet --no-progress & composer_pid=$!

# Build
print_color "${COLOR_LPURPLE}" "Install Frontend Packages and Build \n"
npm install --quiet
npm run build & npm_pid=$!

# Wait for composer install
wait $composer_pid $npm_pid

chmod -R 777 storage bootstrap/cache
ln -s ../storage/app/public public/storage

# Pack
zip --symlinks -rq ./${VERSION}.zip ./* -x node_modules/\*
