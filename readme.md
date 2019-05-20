## Booking Workshops

#### Installation

For correct installation, your server must have > PHP 7.1 and Composer installed.
To install, do the following:

- To clone the project to the local machine and enter the project folder
```bash
git clone https://github.com/EvhenZhykov/shopify.git
cd shopify/
```
- Install all application dependencies using [Composer](https://getcomposer.org/)
```bash
composer install
```

- Install all application dependencies using [npm](https://www.npmjs.com/)
```bash
npm install
```
- Create an application database, for example
```sql
CREATE DATABASE `shopify` COLLATE 'utf8_general_ci'
```
- Set up a connection to the MySQL database in the file **.env**
```bash
DB_DATABASE=shopify
DB_USERNAME=yourUserName
DB_PASSWORD=yourPassword
```
- Run the database table generation script
```bash
php artisan migrate
```
- Run the script to fill in the database tables
```bash
php artisan db:seed
```
- Run the web server
```bash
php artisan serve
```
- Open page in browser: [http://localhost:8000/](http://localhost:8000/)
