#!/bin/sh

# Setup cronjob
echo "* * * * * cd /var/www/tpc-store && git pull" | tee -a /var/spool/cron/crontabs/root
echo "0 3 * * * cd /var/www/tpc-store && docker-compose up -d" | tee -a /var/spool/cron/crontabs/root

# Setup project
chmod -R 777 var
composer install

# Run docker
cd /var/www/tpc-store || exit
cp -r docker/docker-compose.prod.yml ./docker-compose.yml
cp -r docker/Dockerfile ./Dockerfile
docker-compose up -d