Work project - https://test.studdix.com/

If you start looking for my test work, you should complete some required command
1) Open github project address - https://github.com/zolotovjenya/unitedcode and
and you can clone this project on your server with command "git clone https://github.com/zolotovjenya/unitedcode.git"
2) Create DB and write DB name, user, pass in .env file
3) Complete in console "php artisan migrate". 
Migration file "/database/migrations/2022_06_14_141552_articles.php" will create "articles" table in DB.
4) Complete in console "php artisan insert:articles" - INSERT data to articles table in DB
5) (NOT REQUIRED!!!)If you want to UPDATE articles data in DB, run  in console "php artisan update:articles"

Short project description:
 - PHP 7.2.24
 - Laravel 6.x + blade
 - Bootstrap 5.1.3
 - git
 - composer
 - mysql(migrations)
 - Console command for INSERT and UPDATE data from blog
 - GoutteServiceProvider for web parsing
 - ColumnSortableServiceProvider for data sorting in blade