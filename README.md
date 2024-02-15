<a name="readme-top"></a>

<!-- GETTING STARTED -->
## Getting Started

This repository provides you a development environment without requiring you to install PHP, a web server, and any other server software on your local machine. For this, it requires only Docker.

Front-end repository > https://github.com/sohel40b/vue-app.git

### Version

- PHP > 8.2.12
- Laravel > 10.33.0
- Mongodb > v7.0.4
- Mongodb Package > 4.1.0
- VueJS > 3

### Installation

This is an example of how you may give instructions on setting up your project locally. To get a local copy up and running follow these simple example steps.

1. Clone the repository
   ```sh
   git clone https://github.com/sohel40b/LaravelMongoDB.git
   ```
2. Switch to the project folder and open terminal 
   ```sh
   docker build -t laravel-mongodb-web .
   ```
   ```sh
   docker network create laravel-mongodb-network
   ```
   ```sh
   docker run --name laravel-mongodb-web -v ./src:/var/www/html -d -p 8000:80 --network laravel-mongodb-network -e DB_HOST=mongodb -e DB_PORT=27017 -e DB_DATABASE=laravel_mongodb -e DB_USERNAME=root -e DB_PASSWORD=root -e DB_CONNECTION=mongodb laravel-mongodb-web
   ```
   ```sh
   docker volume create mongodbdata
   ```
   ```sh
   docker run --name mongodb --network laravel-mongodb-network -e MONGO_INITDB_ROOT_USERNAME=root -e MONGO_INITDB_ROOT_PASSWORD=root -d -p 27017:27017 -v mongodbdata:/data/db mongo:latest
   ```
3. Open Docker-Desktop app and run command in laravel-mongodb-web image terminal
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
