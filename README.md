## Requirements
- PHP >=7.2
- More...

## Cara Install
- copy .env.example , lalu rename menjadi .env
- Nyalakan **MySQL** pastikan database sudah dibuat.
- Jalankan `composer install`, `php artisan migrate --seed` / `php artisan migrate:fresh --seed`
- Lalu jalankan `php artisan key:generate`
- Jalankan `php artisan serve` untuk menjalankan Laravel dengan port `127.0.0.1:8000`
- Jalankan `npm install && npm run dev` jika diperlukan 

## Akses API
- Buka postman / software sejenisnya / tulis dengan code anda sendiri
- Akses login untuk mendapatkan token dengan detail dibawah ini :
    1.	Url : http://localhost:8000/api/login
    2.	Request method : POST
    3.	Request Header :
        Content-Type : application/json
    4.	Request Body JSON Format :
    {
           {
                "email" : "admin@transisi.id",
                "password" : "transisi"
            }
    }
- selanjutnya anda akan mendapatkan token, simpan token tersebut.
- Akses API employee dengan cara :
    1.	Url : http://localhost:8000/api/employee
    2.	Request method : GET
    3.	Request Header :
        Content-Type : application/json
        Authorization: Bearer {{token}}
- Akses API spesific employee dengan cara :
    1.	Url : http://localhost:8000/api/employee/{id}
    2.	Request method : GET
    3.	Request Header :
        Content-Type : application/json
        Authorization: Bearer {{token}}
- Akses API create employee dengan cara :
    1.	Url : http://localhost:8000/api/create
    2.	Request method : POST
    3.	Request Header :
        Content-Type : application/json
        Authorization: Bearer {{token}}
    4.	Request Body JSON Format, contoh :
        {"name":"test","salary":"123","age":"23"} 
- Akses API update employee dengan cara :
    1.	Url : http://localhost:8000/api/update/{id}
    2.	Request method : PUT
    3.	Request Header :
        Content-Type : application/json
        Authorization: Bearer {{token}}
    4.	Request Body JSON Format, contoh :
        {"name":"test","salary":"123","age":"23"} 
- Akses API delete employee dengan cara :
    1.	Url : http://localhost:8000/api/delete/{id}
    2.	Request method : DELETE
    3.	Request Header :
        Content-Type : application/json
        Authorization: Bearer {{token}}

Note : perhatikan API dari http://dummy.restapiexample.com/ karena API ini me-refer ke api tersebut, untuk id 1 terkadang tidak dapat diakses.

## Salah satu sample tampilan API jika berhasil diakses
<img src="https://github.com/fikrihashfi/api-test/blob/master/example_success.png" width="600" height="200">
