# Bonsai CMS - Auth
This package is a part of [Bonsai CMS](https://github.com/bonsaicms).

## Introduction
This package is a server-side (frontend agnostic) authentication backend for Laravel. **It's designed to be used in a combination with an SPA** (Single-Page-Application) frontend. It uses these Laravel packages under the hood:

- [Laravel Fortify](https://github.com/laravel/fortify)
- [Laravel Sanctum](https://laravel.com/docs/8.x/sanctum)

## Example Application
We installed a fresh Laravel application (version 8.12). Then we [followed the installation](https://github.com/bonsaicms/auth-example/commits/master) steps. The result application can be found here: [https://github.com/bonsaicms/auth-example](https://github.com/bonsaicms/auth-example)

## Installation Steps

### 1. Install the package
```bash2
$ composer require bonsaicms/auth
```

### 2. Update your `.env` file
Add the following lines to your `.env` file.
```.env
APP_PROTOCOL=http
APP_DOMAIN="localhost:8080"
APP_URL=${APP_PROTOCOL}://${APP_DOMAIN}
SANCTUM_STATEFUL_DOMAINS=${APP_DOMAIN}
```

### 3. Publish package resources
```bash2
$ php artisan vendor:publish --provider="BonsaiCms\Providers\AuthServiceProvider"
```

### 4. Register service provider
In your `config/app.php` file, add the following service provider class in the `providers` array.
```php
'providers' => [
    ...
+   App\Providers\BonsaiAuthServiceProvider::class,
]
```

### 5. Update your HTTP Kernel
Add the following lines to your `App\Http\Kernel.php` file.
```php
protected $middlewareGroups = [
    ...
    'api' => [
+       \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
        'throttle:api',
        \Illuminate\Routing\Middleware\SubstituteBindings::class,
    ],
+
+   'fortify' => [
+       \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
+       \Illuminate\Routing\Middleware\SubstituteBindings::class,
+   ],
];
```

### 6. Update your `User` model
Update your `app/Models/User.php` model.

Your model should **implement** our interface `BonsaiCms\Auth\AuthenticatableContract`.

Your model should **use** our trait `BonsaiCms\Auth\AuthenticatableTrait`.

```php
    <?php
    
    namespace App\Models;

+   use Illuminate\Database\Eloquent\Model;
+   use BonsaiCms\Auth\AuthenticatableTrait;
+   use BonsaiCms\Auth\AuthenticatableContract;
    use Illuminate\Contracts\Auth\MustVerifyEmail;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
-   use Illuminate\Foundation\Auth\User as Authenticatable;
-   use Illuminate\Notifications\Notifiable;
    
-   class User extends Authenticatable
+   class User extends Model implements AuthenticatableContract
    {
-       use HasFactory, Notifiable;
+       use HasFactory, AuthenticatableTrait;
```

### 7. Run migrations
```bash2
$ php artisan migrate
```
