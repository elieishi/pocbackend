#!/bin/bash
# exit when any command fails
set -e


# Configure terminal colours
# https://misc.flogisoft.com/bash/tip_colors_and_formatting
green='\e[1;32m%s\e[0m'
red='\e[1;31m%s\e[0m'
cyan='\e[1;36m%s\e[0m'
light_yellow='\e[93m%s\e[0m'
dim='\e[2m%s\e[0m'

failure=false

echo Starting building process
docker-compose build

printf "$cyan\n" "Application Configuration:"
printf ".env... "
if [ ! -f ".env" ]; then
    printf "$red\n" "missing"
    printf "$light_yellow\n" "* Please get a copy of the '.env' file from .env.example"
    failure=true
else
    printf "$green\n" "ok"
fi

if [ "$failure" = true ]; then
    printf "\n$light_yellow\n" "Please resolve the above issues (marked with *) before re-trying"
    exit;
fi

export $(cat .env | grep -v ^# | xargs);


echo Starting services
docker-compose up -d

until docker-compose exec db mysql -h 127.0.0.1 -u $DB_USERNAME -p$DB_PASSWORD -D $DB_DATABASE --silent -e "show databases;"
do
  echo "Waiting for database connection..."
  sleep 5
done

echo Seeding database
rm -f bootstrap/cache/*.php
docker-compose exec app php artisan migrate --env=local && echo Database migrated
docker-compose exec app php artisan db:seed --env=local && echo Database seeded
docker-compose exec app php artisan passport:install --env=local && echo Default clients created

