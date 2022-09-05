<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

## Project Requirements - “Aspire mini API”

Clone the Repository go to folder aspire-bechallenge 
- composer install 

- Create .env using .env example
- Change the db values in .env
    - DB_CONNECTION=mysql
    - DB_HOST=127.0.0.1
    - DB_PORT=3306
    - DB_DATABASE=your_database
    - DB_USERNAME=root
    - DB_PASSWORD=


- php artisan key:generate (if keys missing)

- Use php artisan migrate --seed to create tables and seed it with default values

- php artisan serve to run the server


## Postman Collection 

https://www.getpostman.com/collections/932b47e7998738691308


## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
