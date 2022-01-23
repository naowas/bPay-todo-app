# Getting started

## Installation

Please check the official laravel installation guide for server requirements before you
start. [Official Documentation](https://laravel.com/docs/5.4/installation#installation)

Clone the repository

    $ git clone https://github.com/naowas/bPay-todo-app.git

Switch to the repo folder

    $ cd bPay-todo-app

Install all the dependencies using composer and npm

    $ composer install
    $ npm install 
    $ npm run dev

Copy the example env file and make the required configuration changes in the .env file

    $ cp .env.example .env

Generate a new application key

    $ php artisan key:generate

Run the database migrations and seed  (**Set the database connection in .env before migrating**)

    $ php artisan migrate
    $ php artisan db:seed

Start the local development server

    $ php artisan serve

You can now access the server at http://localhost:8000

**For access to the application, use the credentials listed below.**

    email: admin@mail.com
    password: password

**This application require scheduler to create todo remainder email queue.**

Configure **cron** jobs

    $ crontab -e
    * * * * * cd /path-to-project && php artisan schedule:run >> /dev/null 2>&1

**For sending email form queue we need Supervisor to run our queue in the background**

Install **supervisor** (_Ubuntu/Debian_)

    $ sudo apt-get update
    $ sudo apt-get install supervisor

Now navigate to **supervisor** config directory

    $ cd /etc/supervisor/conf.d

Create a new config file inside /etc/supervisor/conf.d

    $ touch queue-worker.conf

Open _queue-worker.conf_ with a text editor (nano,vim,gedit,etc.)

    $ sudo vim queue-worker.conf

Configure _queue-worker.conf_ as follows (replace `path-to-project` with your project directory)

        program:queue-worker
        process_name=%(program_name)s_%(process_num)02d
        command=php /var/www/path-to-project/artisan queue:work
        autostart=true
        autorestart=true
        stopasgroup=true
        killasgroup=true
        user=root
        numprocs=8
        redirect_stderr=true
        stdout_logfile=/home/user/log/worker.log


**Once we saved the contents we need to run following command to initialize new configurations**

    read the new config
    $ sudo supervisorctl reread

    activate configuration
    $ sudo supervisorctl update

    Restart superviser processes
    $ sudo supervisorctl restart all


    
