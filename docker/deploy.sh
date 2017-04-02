#!/usr/bin/env bash
# Install required packages
sudo apt-get install -y --no-install-recommends apt-transport-https ca-certificates curl software-properties-common git && \

# Get and install Docker
curl -fsSL https://apt.dockerproject.org/gpg | sudo apt-key add - && \
sudo add-apt-repository "deb https://apt.dockerproject.org/repo/ ubuntu-$(lsb_release -cs) main" && \
sudo apt-get update && \
sudo apt-get install -y docker-engine && \
curl -L "https://github.com/docker/compose/releases/download/1.11.1/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose && \
sudo chmod +x /usr/local/bin/docker-compose && \

# Clone the Project and setup environment
git clone https://github.com/brackets-extension-badges/badge-provider-php && \
cd badge-provider-php && \
cp .env.example .env && \
APP_KEY=$(cat /dev/urandom | tr -dc 'a-zA-Z0-9' | fold -w 32 | head -n 1) && \
SECRET=$(cat /dev/urandom | tr -dc 'a-z0-9' | fold -w 16 | head -n 1) && \
sed -i "s/\[RANDOM KEY HERE\]/$APP_KEY/g" .env && \
sed -i "s/\[SECRET STRING HERE\]/$SECRET/g" .env && \

# Add the Laradock submodule and update docker-compose.yml
git submodule add https://github.com/Laradock/laradock.git && \
cd laradock && \
rm docker-compose.yml && \
cp ../docker/docker-compose.yml.example docker-compose.yml && \

# Create the docker containers for the first time
docker-compose up -d nginx mysql && \
docker-compose exec mysql sh -c "sed -i '/user/d' /etc/mysql/startup" && \
docker-compose restart mysql && \
docker-compose exec workspace sh -c 'echo "{}" > storage/app/list.json && chmod -R 777 storage' && \

# Install composer dependencies
docker-compose exec workspace sh -c 'composer install' && \

# create tables and fill database
docker-compose up -d nginx mysql && \
docker-compose exec workspace sh -c 'php artisan migrate && php artisan data:update' && \

# Add cron to run docker after boot
echo "@reboot cd $(pwd) && docker-compose up -d nginx mysql" >> /etc/crontab && \

# Add cron to update data every hour
echo "0 * * * * cd $(pwd) && docker-compose exec workspace sh -c 'php artisan data:update'" >> /etc/crontab && \

# Finished!
IP=$(curl ipinfo.io/ip) && \
cd ../.. && \
rm setup.sh && \
echo ========================= && \
echo Setup sucessfull! && \
echo Badge provider available at http://$IP && \
echo Visit http://$IP/update/$SECRET to update data