# Getting started

## Installation

Please check the official laravel installation guide for server requirements before you start. [Official Documentation](https://laravel.com/docs/5.4/installation#installation)


Clone the repository

    git clone https://github.com/naowas/bPay-todo-app.git

Switch to the repo folder

    cd bPay-todo-app

Install all the dependencies using composer and npm

    composer install
    npm install && npm run dev


Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

Generate a new application key

    php artisan key:generate

Run the database migrations and seed  (**Set the database connection in .env before migrating**)

    php artisan migrate
    php artisan db:seed


Start the local development server

    php artisan serve

You can now access the server at http://localhost:8000

**For access to the application, use the credentials listed below.**

    email: admin@mail.com
    password: password
