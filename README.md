If you start looking for my test work, you should complete some required command
1) Open github project address - https://github.com/zolotovjenya/unitedcode
2) Create DB and write DB name, user, pass in .env file
3) Complete in console "php artisan migrate" - this command from /database/migrations/2022_06_14_141552_articles.php and create "articles" table in DB
4) Complete in console "php artisan insert:articles" - INSERT data to articles table in DB
5) (NOT REQUIRED!!!)If you want to UPDATE data in DB run "php artisan update:articles"

Short project description:
 - PHP 7.2.24
 - Laravel 6.x + blade
 - mysql(migrations)
 - Console command for INSERT and UPDATE data from blog
 - GoutteServiceProvider for web parsing
 - ColumnSortableServiceProvider for data sorting in blade