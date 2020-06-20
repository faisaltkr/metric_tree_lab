<a href="https://aimeos.org/">
    <img src="https://www.courseya.com/interview/laravel-interview-questions.jpg" alt="Aimeos logo" title="Aimeos" align="right" height="60" />
</a>

# METRIC TREE LAB

![METRIC TREE LAB](https://www.courseya.com/interview/laravel-interview-questions.jpg)

## Download or Clone the project

### For installing packages

```
composer install
```

### Create a Database and connect

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=metrictree
DB_USERNAME=root
DB_PASSWORD=
```

## Migrate all tables including passport
```
php artisan migrate
```
## [Installing Passport](https://laravel.com/docs/7.x/passport)
```
php artisan passport:install
```
## Creating A Personal Access Client

```
php artisan passport:client --personal
```


## To create the symbolic link for Files
```
php artisan storage:link
```

## Local Deploying
```
php artisan serve
```
## Route URIs 

### Signup 
```
[POST] : http://127.0.0.1:8000/api/v1/signup 
```
### Login  
```
[POST] : http://127.0.0.1:8000/api/v1/login 
```
### Create Note 
```
[POST] : http://127.0.0.1:8000/api/v1/notes
```
### All Notes of Authenticated User
```
[GET] : http://127.0.0.1:8000/api/v1/notes
```
### Update Note
```
[POST] : http://127.0.0.1:8000/api/v1/notes/1
Additional Patameter [_method] : PUT 
```
### Delete Note 
```
[POST] : http://127.0.0.1:8000/api/v1/notes/1
Additional Patameter [_method] : DELETE 
```
## All calls must have headers below
```
  'headers' => [
        'Authorization' => 'Bearer '.$token,
        'Accept' => 'application/json',
    ],
```

