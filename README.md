# symfony

First of all you need to install all the dependencies by typing in terminal this command 
        composer install


then you  all have to do is changing the user and password in .env file to your mysql login  and then type this commands    
    php bin/console doctrine:database:create
    php bin/console make:migration
    php bin/console doctrine:migrations:migrate
