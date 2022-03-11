## Laravel 9

### Install the project with Sail

```
curl -s "https://laravel.build/example-app?with=mysql" | bash
```

### Change DB credentials

When installing a new Laravel project with Sail it is possible to change
credentials to the DB inside the container.

edit the .env, ex.:

```
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=bookstore_db
DB_USERNAME=admin_bs
DB_PASSWORD=Jmb9w7L.h6aj
```

then

```
sail down -v
sail build --no-cache
sail up -d
```

Now you can access to the database

```
sail mysql -u admin_bs -p Jmb9w7L.h6aj
```

### Install passport

Laravel 9 use Sanctum for authentication for APIs, but in this project we instead use Passport and Oauth Authentication 
in the same way it will be in Laravel 8

```
sail composer require laravel/passport

sail php artisan passport:install
```

example console output:
```
  Encryption keys generated successfully.
  Personal access client created successfully.
  Client ID: 1
  Client secret: Hp5SSOR9m9XiQDIci0UoIlebRhl82RWdWft9DIlO
  Password grant client created successfully.
  Client ID: 2
  Client secret: n2xHK5wS3EuEO85zGqorINc1bYHdVyN8i7Onvbbg
```

Include this in User model

```
use Laravel\Passport\HasApiTokens;
```

And this in AuthServiceProvider
```
use Laravel\Passport\Passport;
```

And update the boot method

```
public function boot()
    {
        $this->registerPolicies();
        Passport::routes();
    }
```

Update auth.php inside cnfig folder

```
'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],
        'api' => [
            'driver' => 'passport',
            'provider' => 'users',
            'hash' => false
        ],
    ],
```

Creates new user

```
sail php artisan tinker

>>> DB::table('users')->insert(['name'=>'Rafa', 'email'=>'rafa@mail.com', 'password'=>Hash::make('rafa123456')]);
```

Create an Oauth Token request in Postman

POST http://localhost/oauth/token

In body select form-data

Introduce the following key values

    grant_type      -> password
    client_id       -> 2   (use the generated previously with the command: sail php artisan passport:install)
    client_secret   -> n2xHK5wS3EuEO85zGqorINc1bYHdVyN8i7Onvbbg
    username        -> rafa@mail.com
    password        -> rafa123456
    scope           ->          (let this value empty)

It will generate:

```
{
"token_type": "Bearer",
"expires_in": 31536000,
"access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSU...",
"refresh_token": "def5020053b1f1809a131e347368..."
}
```

Send the request in Postman and it will generate the access_token and the refresh_token

Now use the token in a route protected with the auth middleware
```
key: Authorization
value: Bearer eyJ0eXAiOiJKV1QiLCJh...
```
