# FlexFlux - Laravel Encryptor

Encryptor is a simple package to automatically encrypt and decrypt attributes from your models. Encryptor creates an extra layer of security for your applications data. The encrypted data won't be readable on database level.

## Requires
Laravel version 8.12 or higher.

### Installation ###

* Step 1: Install package via composer.

```bash
composer require flexflux/encryptor
```

* Step 2: Add the Encryptable trait to your models you want to encrypt.
```
use App\Traits\Encryptable;
use Encryptable;
```

* Step 3: Define which attributes you want to encrypt by adding them to your encryptable array inside the model.
```
protected $encryptable = [
        'name'
    ];
```

PLEASE DO NOT encrypt passwords or e-mailaddresses used for authentication. The authentication won't work if you do this.

### Encrypt your production database ###
Requirements:
- All your models needs to be inside the `app\Models` folder of your Laravel project.
- You did all the installation steps above.

To use Encryptor on an application already deployed to production we need to do the following steps on your production application:

* Step 1: First, make sure your application is not used by entering the following command inside your project folder: `php artisan down`. This will put your application offline for your users.


* Step 2: For each model you've added the Encryptable trait by removing (or comment) the `use Encryptable;`. (You can also do this in a commit and push it to your production server or something like that)


* Step 3: Next, we run the following command: `php artisan encryptor:encrypt` inside your project folder. The command should now run through your Laravel models and encrypt each attribute on every row.


* Step 4: Enable the Encryptable trait again on every model. (You can also do this in a commit and push it to your production server or something like that)


* Step 5: Put your application back online by entering the following command: `php artisan up` and your good to go! Your old and new database records are now encrypted at rest.

### Work in progress ###
- I'm planning to make it possible to search on encrypted attributes.