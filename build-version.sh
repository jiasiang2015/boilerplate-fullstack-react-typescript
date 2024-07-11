#!/bin/bash -x


# ====================================================================
# =======           用於連線到 ssh 並且取得最新的版本號           =======

set -e


BUILD_FOLDER=${1}
SSH_DOMAIN=${2}
SSH_KEY_PATH=${3}

printf "\n\n"
printf "=====================================================\n"
printf "GET NEW_VERSION\n"

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

printf "RETRIVIE THE NEW VERSION [v0.0.$NEW_VERSION] \n"

echo $NEW_VERSION
