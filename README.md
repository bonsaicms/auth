# Installation Steps

## 1. Install the package
```bash2
$ composer require bonsaicms/auth
```

## 2. Update your `.env` file
Add the following lines to your `.env` file.
```.env
APP_PROTOCOL=http
APP_DOMAIN="localhost:8080"
APP_URL=${APP_PROTOCOL}://${APP_DOMAIN}
SANCTUM_STATEFUL_DOMAINS=${APP_DOMAIN}
```

## 3. Publish package resources
```bash2
$ php artisan vendor:publish --provider="BonsaiCms\Providers\AuthServiceProvider"
```

## 4. Register service provider
In your `config/app.php` file, add the following service provider class in the `providers` array.
```php
'providers' => [
    ...
+   App\Providers\BonsaiAuthServiceProvider::class,
]
```

## 5. Update your HTTP Kernel
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

## 6. Update your `User` model
Replace a line in your `app/Models/User.php` file:
```php
<?php

namespace App\Models;

    use Illuminate\Contracts\Auth\MustVerifyEmail;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
-   use Illuminate\Foundation\Auth\User as Authenticatable;
+   use BonsaiCms\Models\User as Authenticatable;
    use Illuminate\Notifications\Notifiable;
```

## 7. Run migrations
```bash2
$ php artisan migrate
```
