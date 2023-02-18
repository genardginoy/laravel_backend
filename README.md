## Laravel Backend API Support

## These are the list of api endpoints supported in this project

### Todo Resource

* Read the list of todo items
* Read a specific todo items
* Create a new todo item
* Update the existing todo item
* Delete a specific todo item

#### API documentation

* Todo entity -> [Click here](https://documenter.getpostman.com/view/23446250/2s7Z13jNjD)
* Comment entity over Todo -> [Click here](https://documenter.getpostman.com/view/23446250/2s93CHuEuV)  

## Project Setup

#### _To create laravel project_ 

```
composer create-project laravel/laravel <project-name>
```

#### _To connect with database fille the follwing in (.env)_ 

```
DB_CONNECTION=<db-connection/driver>
DB_HOST=<db-host>
DB_PORT=<db-port>
DB_DATABASE=<database-name>
DB_USERNAME=<db-username>
DB_PASSWORD=<db-password>

```

#### _To migrate table to db_ 

```
php artisan migrate    [In the project root directory]
```

#### _To generate fake data_ 

```
php artisan tinker
App\Models\Todo::factory(30)->create();   [Creates 30 fake random records]
```

#### Now for some fun

* Definitely checkout my [CHANGELOG.md](https://github.com/deepak0023/laravel_backend/blob/master/CHANGELOG.md) for some fun and development process feel
