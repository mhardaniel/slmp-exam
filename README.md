<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

## Requirements

-   Docker Desktop
-   WSL

## Tech Stacks used

-   Laravel
-   Database Connection (MYSQL)
-   Sail

## Running

1. open your terminal
2. ```git clone git@github.com:mhardaniel/slmp-exam.git```
3. ```cd slmp-exam```
4. ```cp .env.example .env```
5. ```php artisan key:generate```
6. ```./vendor/bin/sail up -d```
7. ```php artisan migrate --seed```
8. you can access the api routes at: http://localhost:8000

## API Routes

1. http://localhost:8000/api/users

## Authentication(Basic Auth)
- Username: test@example.com
- Password: password
<img width="1537" height="1301" alt="Image" src="https://github.com/user-attachments/assets/16f807fe-d14d-4c01-9f2b-e2497daac5ca" />

## Running Console Command
```
sail artisan fetch:mock-data
```


### Thank you, Regards

mhardaniel
