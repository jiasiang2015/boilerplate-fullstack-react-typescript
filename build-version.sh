#!/bin/bash -x


# ====================================================================
# =======           用於連線到 ssh 並且取得最新的版本號           =======

set -e

# 顏色 Color
COLOR_LBULE='\033[1;34m'
COLOR_LGREEN='\033[1;32m'
COLOR_LPURPLE='\033[1;35m'
COLOR_NONE='\033[0m' # No Color

BUILD_FOLDER=${1}
SSH_DOMAIN=${2}
SSH_KEY_PATH=${3}

printf "\n\n"
printf "${COLOR_LBULE} =====================================================\n ${COLOR_NONE}"
printf "${COLOR_LBULE} GET NEW_VERSION\n ${COLOR_NONE}"

OUTPUT=$(ssh $SSH_DOMAIN -i $SSH_KEY_PATH << EOF
    cd /opt/$BUILD_FOLDER
    echo "xxxxxxxxxxxxxxxxxxxxxxxx"
    ls
EOF
)

# 使用 xxxxxxxxxxxxxxxxxxxxxxxx 作為字串分割，並且取最後一筆
LS_SECTION=$(echo "$OUTPUT" | sed 's/xxxxxxxxxxxxxxxxxxxxxxxx/\n/g' | tail -n 1)

VERSIONS=$(echo $LS_SECTION | grep -o 'v0\.0\.[0-9]\+')

LARGEST_VERSION=$(echo $VERSIONS | tr ' ' '\n' | sort -V | tail -n 1 | cut -d '.' -f 3)

NEW_VERSION=$((LARGEST_VERSION + 1))

printf "${COLOR_LBULE} RETRIVIE THE NEW VERSION ${COLOR_LGREEN}[v0.0.$NEW_VERSION] \n ${COLOR_NONE}"

echo $NEW_VERSION
