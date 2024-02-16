<a name="readme-top"></a>

<!-- GETTING STARTED -->
## Getting Started

This repository provides you a development environment without requiring you to install PHP, a web server, and any other server software on your local machine. For this, it requires only Docker.

### Version

- PHP > 8.2.12
- Laravel > 10.33.0
- Mongodb > v7.0.4
- Mongodb Package > 4.1.0

### Installation

This is an example of how you may give instructions on setting up your project locally. To get a local copy up and running follow these simple example steps.

1. Clone the repository
   ```sh
   git clone https://github.com/sohel40b/LaravelMongoDBDocker.git
   ```
2. Switch to the project folder and goto new terminal 
   ```sh
   docker build -t php -f Dockerfile.php .
   ```
    ```sh
   docker build -t nginx -f Dockerfile.nginx .
   ```
   ```sh
   docker network create laravel-mongodb-network
   ```
   ```sh
   docker run -d --name php --network laravel-mongodb-network -v ./:/var/www/html php
   ```
   ```sh
   docker run -d --name nginx -p 8000:80 --network laravel-mongodb-network -v ./:/var/www/html --link php:php nginx
   ```
   ```sh
   docker volume create mongodbdata
   ```
   ```sh
   docker run -d --name mongodb -p 27017:27017 --network laravel-mongodb-network -v mongodbdata:/data/db -e MONGO_INITDB_ROOT_USERNAME=root -e MONGO_INITDB_ROOT_PASSWORD=root mongo:latest
   ```
3. Open Docker-Desktop app or terminal and connect php container also run commannd in /src directory 
   ```sh
   cp .env.example .env
   ```
   Edit .env file
   ```sh
   DB_CONNECTION=mongodb
   DB_HOST=mongodb
   DB_PORT=27017
   DB_DATABASE=laravel_mongodb
   DB_USERNAME=root
   DB_PASSWORD=root
   ```
   ```sh
   composer install
   ```
   ```sh
   php artisan key:generate 
   ```
   ```sh
   php artisan migrate
   ```
<p align="right">(<a href="#readme-top">back to top</a>)</p>
