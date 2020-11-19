# Assignment Project
This project is built with CodeIgniter 4.0.4

## Server Requirements

PHP version 7.2 or higher is required, with the following extensions installed: 

- [intl](http://php.net/manual/en/intl.requirements.php)

Additionally, make sure that the following extensions are enabled in your PHP:

- json (enabled by default - don't turn it off)
- [mbstring](http://php.net/manual/en/mbstring.installation.php)
- [mysqlnd](http://php.net/manual/en/mysqlnd.install.php)
- xml (enabled by default - don't turn it off)

For more about [server requirements](https://codeigniter4.github.io/userguide/intro/requirements.html).

## To get the project to work

- Import database dump which is located in: app/Database/dump.sql to your mySQL server
- Rename env file to .env and modify it to your database server info
- In app/Config/App.php change $baseURL variable to the correct URL of your copy of the project

