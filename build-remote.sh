#!/bin/bash -x

set -e

SSH_USERNAME=${1}
SSH_DOMAIN=${2}
SSH_KEY_PATH=${3}
NEW_VERSION=${4}

# OUTPUT=$(ssh $SSH_USERNAME@$SSH_DOMAIN -i $SSH_KEY_PATH << 'EOF'
#     cd /opt/bill-test/
#     echo "xxxxxxxxxxxxxxxxxxxxxxxx"
#     ls
# EOF
# )

# # Split the output using the delimiter and focus on the part after it
# LS_SECTION=$(echo "$OUTPUT" | sed 's/xxxxxxxxxxxxxxxxxxxxxxxx/\n/g' | tail -n 1)

# VERSIONS=$(echo $LS_SECTION | grep -o 'v0\.0\.[0-9]\+')

# LARGEST_VERSION=$(echo $VERSIONS | tr ' ' '\n' | sort -V | tail -n 1 | cut -d '.' -f 3)

# NEW_VERSION=$((LARGEST_VERSION + 1))

printf "\n\n\n"
printf "=====================================================\n"
printf "GET NEW_VERSION: v0.0.$LARGEST_VERSION\n"

printf "\n\n\n"
printf "=====================================================\n"
printf "CREATE FOLDER\n"

ssh $SSH_USERNAME@$SSH_DOMAIN -i $SSH_KEY_PATH << EOF

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

scp -i $SSH_KEY_PATH ./output/v0.0.$NEW_VERSION.zip $SSH_USERNAME@$SSH_DOMAIN:/opt/bill-test/v0.0.$NEW_VERSION


printf "\n\n\n"
printf "=====================================================\n"
printf "UNPACKING ZIP AND SETTINGS\n"

ssh $SSH_USERNAME@$SSH_DOMAIN -i $SSH_KEY_PATH << EOF

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