## Laravel Task management system

The project is the task management system with a draggable task.

## perquisite to run this application

you should have docker and composer on your local machine

## Install application on your local Machine

Clone or download the application and run composer install to install all the packages. Edit the .env file.

## Docker

cd into the root of the application folder and run

```bash
sail up
```

in your cmd to run the aplication

## Run Migration

To run migrations, execute the migrate Artisan

```bash
sail artisan migrate
```

## Run Seeder

To run seeder, execute the seed Artisan

```bash
sail artisan db:seed'
```

## link to perform crud

http://localhost/tasks
