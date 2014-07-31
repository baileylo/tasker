# Tasker

Sensibility brought to task management.

## Installation

This requires composer, you can find installation instructions for that

```
git clone git@github.com:baileylo/tasker.git
cd tasker
composer install
```

Open up `app/config/production/database.php` and modify the database configurations.

Open up `app/config/production/app.php` and url to the url for your site url.

From your terminal run `php artisan install`. This will walk you through creating your user account as well as setting up your first project.

## Development mode

Open `app/config/environment.php` and change the returned value from *production* to *local*.

### Compiling CSS and JS

From the tasker root directory run

```
npm install
grunt
``` 




