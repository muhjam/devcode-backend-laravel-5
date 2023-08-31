# Devcode Starter Laravel Level 5

## Hasil Akhir yang Diharapkan

Peserta dapat memvalidasi data dari request body sebelum data tersebut disimpan ke database

## Setup Environment

1. Download source code melalui link yang telah disediakan dari halaman assesment
2. Extract source code yang sudah terdownload pada perangkat anda
3. Buka source code yang sudah diextract menggunakan Code Editor, contoh Visual Studio Code
4. Salin isi dari file `.env.example` ke dalam file `.env`
5. Ubah konfigurasi database pada project dengan mengubah baris kode pada file `config/database.php`, untuk langkah-langkahnya bisa dilihat [disini](#konfigurasi-db)
6. Jalankan `composer install` pada terminal
7. Jalankan `php artisan key:generate` pada terminal
8. Jalankan `php artisan serve` untuk mode development pada terminal

## Instruksi Pengerjaan

1. Pastikan anda sudah meng-install tools yang diperlukan. Jika belum, silahkan ikuti langkah-langkahnya [disini](#menginstal-tools-yang-diperlukan)
2. Tambahkan validasi pada data yang akan dijadikan request body di route POST, PUT, DELETE pada file `routes/api.php`, untuk detail requirement validasinya dapat dilihat [disini](#detail-validasi-untuk-request-payload)
3. Lakukan unit testing pada local anda dengan menggunakan Docker, langkah-langkahnya dapat dilihat [disini](#menjalankan-unit-testing-dengan-Docker)
4. Push projek ke docker hub setelah semua test case berhasil dijalankan, langkah-langkahnya dapat dilihat [disini](#push-projek-ke-docker-hub)
5. Submit image docker yang telah dipush ke Docker Hub ke Halaman Submission Devcode, langkah-langkahnya dapat dilihat [disini](#push-projek-ke-docker-hub)

## Tools dan Packages yang Digunakan

1. [Git](https://git-scm.com)
2. [Docker](https://www.docker.com)
3. [Laravel](https://laravel.com/)
3. [Composer](https://getcomposer.org/)

## Menginstal Tools yang Digunakan

-   [Git](https://git-scm.com/book/en/v2/Getting-Started-Installing-Git)
-   [Composer](https://getcomposer.org/doc/00-intro.md)
-   Docker
    -   [Windows](https://docs.docker.com/desktop/install/windows-install/)
    -   [Mac](https://docs.docker.com/desktop/install/mac-install/)
    -   [Linux](https://docs.docker.com/desktop/install/linux-install/)

## Detail Validasi untuk Request Payload
- Untuk route POST, validasi yang dibutuhkan adalah
  - full_name, phone_number, email tidak boleh kosong
  - full_name, phone_number, email yang akan disimpan tidak boleh sama dengan data yang sudah ada
- Untuk route PUT, validasi yang dibutuhkan adalah
  - full_name, phone_number, email tidak boleh kosong
  - cek apakah id kontak yang akan diupdate ada di dalam database
- Untuk route DELETE, validasi yang dibutuhkan adalah
  - cek apakah id kontak yang akan diupdate ada di dalam database

## Konfigurasi DB
di file `config/database.php` ubah env menjadi sebagai berikut:
- DB_HOST menjadi MYSQL_HOST
- DB_PORT menjadi MYSQL_PORT
- DB_DATABASE menjadi MYSQL_DBNAME
- DB_USERNAME menjadi MYSQL_USER
- DB_PASSWORD menjadi MYSQL_PASSWORD

Hidupkan database dengan eksekusi perintah `docker compose up db -d`, kemudian buat model & migration untuk Contact dengan command `php artisan make:model Contact -m`
adapun ketentuan untuk skema db adalah sebagai berikut:
- id int primary key
- full_name string 255
- phone_number string 20
- email string 255

Jangan lupa untuk menyesuaikan .env anda agar menggunakan config env yang sudah diubah sebelumnya. kemudian execute command `php artisan migrate` untuk membuat table

## Menjalankan Unit Testing dengan Docker

### Build Docker Image

Jalankan perintah berikut untuk Build docker image `docker build . -t {name}`

contoh :

```
docker build . -t laravel-hello
```

### Jalankan Docker Image

Jalankan docker image dengan perintah `docker run -e PORT=3030 -p 3030:3030 {docker image}`

contoh:

```
docker run -e PORT=3030 -p 3030:3030 laravel-hello
```

### Jalankan Unit Testing

Pastikan port ketika menjalankan docker image sama dengan `API_URL` ketika ingin menjalankan unit testing.

Jalankan perintah berikut untuk menjalankan unit testing di local:

```
docker run --network="host" -e API_URL=http://localhost:3030 -e LEVEL=1 alfi08/hello-unit-testing
```

## Submit Docker Image ke Devcode

### Build Docker Image

Jalankan perintah berikut untuk Build docker image `docker build . -t {name}`

Contoh :

```
docker build . -t nodejs-hello
```

### Push projek ke Docker Hub

Pastikan sudah memiliki akun docker hub, dan login akun docker anda di lokal dengan perintah `docker login`.

Setelah itu jalankan perintah berikut untuk push docker image lokal ke docker hub.

```
docker tag laravel-hello {username docker}/laravel-hello
docker push {username docker}/laravel-hello
```

Setelah itu submit docker image ke Devcode.

```
{username docker}/laravel-hello
```
