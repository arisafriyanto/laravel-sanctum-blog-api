<h1 align="center">Laravel Sanctum Blog API</h1>

> Base url of this service is: http://localhost:8000

## How to Install

#### 1. Clone repository with the following command:

```bash
git clone https://github.com/arisafriyanto/laravel-sanctum-blog-api.git
```

#### 2. Move to the repository directory with the command:

```bash
cd laravel-sanctum-blog-api
```

#### 3. Run the following command to install the depedency:

```bash
composer install
```

#### 4. Copy the `.env.example` file, rename it to `.env`:

```bash
cp .env.example .env
```

#### 5. Run the following command to generate application key:

```bash
php artisan key:generate
```

#### 6. Edit the `.env` file to customize your database configuration:

```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_username
DB_PASSWORD=your_database_password
```

#### 7. Run the migration to create tables in the database:

```bash
php artisan migrate
```

#### 8. Run the seeder to insert data into the database table:

```bash
php artisan db:seed
```

#### 9. Run the Laravel server with the command:

```bash
php artisan serve
```

   <br>
  
## Documentation

This API uses Postman to documentation.

You can access here:

> [Link Documentation](https://documenter.getpostman.com/view/33657932/2sAXxMgDyW)

## Contact

Please contact [arisapriyanto.new@gmail.com](mailto:arisapriyanto.new@gmail.com).

#### Thank you !!
