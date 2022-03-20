# ChampionshipLeague

<h3>REQUIREMENTS</h3>

php >= 8.0

composer - https://getcomposer.org/

symfony - https://symfony.com/download

mysql - https://www.mysql.com/downloads/

<h3>INSTALLATION</h3>

Clone project to on your local machine.

1.). Run the command "Composer install"

2.) Fill the mysql database information in env file.
      DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/db_name?serverVersion=5.7&charset=utf8mb4"

3.) Run the migrations
      php bin/console doctrine:migration:migrate
      
4.) Run the fixtures for create teams
      php bin/console doctrine:fixturex:load
      
4.) Now you can start the symfony server
      symfony server:start -d -port={PORT}


<img width="1675" alt="image" src="https://user-images.githubusercontent.com/52002022/159169419-b1aded37-7d98-4d09-812e-85c410a3ba79.png">
