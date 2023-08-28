# Logitech test assigment

## Requirements for local environment

* Mysql  Ver 8.1.0
* PHP 8.2.9
* Composer
* Laravel Framework 10.20.0
* Node v20.5.1

## Initial Setup

1) php artisan migrate
2) Seed the DB with test data
   * php artisan db:seed --class=FollowersTableSeeder
   * php artisan db:seed --class=SubscribersTableSeeder
   * php artisan db:seed --class=DonationsTableSeeder
   * php artisan db:seed --class=MerchSalesTableSeeder
   
## Start backend 
 * php artisan --version
 
## Start frontend
 * npm start
 
 Service should be available by link: 
 http://localhost:3000/
