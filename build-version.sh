#!/bin/bash -x

set -e

SSH_USERNAME=${1}
SSH_DOMAIN=${2}
SSH_KEY_PATH=${3}

OUTPUT=$(ssh $SSH_USERNAME@$SSH_DOMAIN -i $SSH_KEY_PATH << EOF
    cd /opt/bill-test/
    echo "xxxxxxxxxxxxxxxxxxxxxxxx"
    ls
EOF
)

# Split the output using the delimiter and focus on the part after it
LS_SECTION=$(echo "$OUTPUT" | sed 's/xxxxxxxxxxxxxxxxxxxxxxxx/\n/g' | tail -n 1)

VERSIONS=$(echo $LS_SECTION | grep -o 'v0\.0\.[0-9]\+')

LARGEST_VERSION=$(echo $VERSIONS | tr ' ' '\n' | sort -V | tail -n 1 | cut -d '.' -f 3)

NEW_VERSION=$((LARGEST_VERSION + 1))

echo $NEW_VERSION
