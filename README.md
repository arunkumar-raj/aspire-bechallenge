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

## Brief documentation for the project: the choices made and why

https://drive.google.com/file/d/1OdG9PO7apFKMuwI9Mk8Oj7_ZFrYyrv0x/view?usp=sharing


## API Links For Reference

- Admin Register -> POST Method -> http://127.0.0.1:8000/api/v1/admin/register -> Parameters (name,email,password) 

- Admin login -> POST Method -> http://127.0.0.1:8000/api/v1/admin/login -> Parameters (email,password) 

- Admin Loans List -> GET Method -> http://127.0.0.1:8000/api/v1/loan/list

- Admin Single Loan View -> GET Method -> http://127.0.0.1:8000/api/v1/loan/single/{loan-id}

- Admin Approve Loan -> PUT Method -> http://127.0.0.1:8000/api/v1/loan/approve/{loan-id}

- Admin Delete Loan -> DELETE Method -> http://127.0.0.1:8000/api/v1/loan/delete/{loan-id}

- Admin Logout -> POST Method -> http://127.0.0.1:8000/api/v1/admin/logout 



- Customer Register -> POST Method -> http://127.0.0.1:8000/api/v1/user/register -> Parameters (name,email,password) 

- Customer login -> POST Method -> http://127.0.0.1:8000/api/v1/user/login -> Parameters (email,password) 

- Apply Loan -> POST Method -> http://127.0.0.1:8000/api/v1/loan/apply -> Parameters (amount,term) 

- User Loans List -> GET Method -> http://127.0.0.1:8000/api/v1/loan/list

- Repay Schedules list -> GET Method -> http://127.0.0.1:8000/api/v1/repayloan/schedules

- Repay Single View -> GET Method -> http://127.0.0.1:8000/api/v1/repayloan/single/{repayment-id}

- Repay Payment -> PUT Method -> http://127.0.0.1:8000/api/v1/repayloan/payment/{repayment-id} -> Parameters (amount) 



## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
