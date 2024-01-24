<a name="readme-top"></a>

<!-- GETTING STARTED -->
## Getting Started

This repository provides you a development environment without requiring you to install PHP, a web server, and any other server software on your local machine. For this, it requires only Docker.

### Version

- PHP > 8.2.12
- Laravel > 10.33.0
- Mongodb > v7.0.4
- Mongodb Package > 4.1.0
- VueJS > 3

### Installation

This is an example of how you may give instructions on setting up your project locally. To get a local copy up and running follow these simple example steps.

1. Clone the repo
   ```sh
   git clone https://github.com/sohel40b/LaravelMongoDB.git
   ```
2. Switch to the project folder and open terminal 
   ```sh
   docker-compose build
   ```
   ```sh
   docker-compose up -d
   ```
3. Open Docker-Desktop app and run command in php image terminal
   ```sh
   cp .env.example .env
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
4. Change your code in `.env`
   ```js
   DB_HOST: db
   ```
<!-- Documentation -->
## Documentation

Documentation URL provide below.
```sh
http://localhost:8000/request-docs/
```

<p align="right">(<a href="#readme-top">back to top</a>)</p>
