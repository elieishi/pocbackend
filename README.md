## POC System

POC system that is used as a REST Backend API for POC. The system is accessible at the following url: http://localhost/

### Technology Stack
- laravel 7.18.0
- laravel/passport
- docker & docker-compose


## Bring up the environment
On Mac, you should be able to bring up the entire environment using the below command:
```bash
./setup.sh
```

Once setup initially, you can stop the environment with `docker-compose stop`, and bring it back up with `docker-compose up`. To stop & remove the containers, networks & images use `docker-compose down`.

## Database Migrations and Seeding
The above `./setup.sh` script ran the database migrations and seeding for you but if you need to run them later you can use the following commands:
```
docker-compose run --rm app php artisan migrate
docker-compose run --rm app php artisan db:seed
```


## Running automated tests
if you need to run automated tests can use the following commands:
```
docker-compose run --rm app  vendor/bin/phpunit
```


