# FlexFlux - Laravel Encryptor

Encryptor is a simple package to automatically encrypt and decrypt attributes from your models. Encryptor creates an extra layer of security for your applications data. The encrypted data won't be readable on database level.

## Requires
Laravel version 8.12 or higher.

### Installation ###

* Step 1: Install package via composer.

```bash
composer require flexflux/encryptor
```

* Step 2: Add the EncryptorServiceProvider to your providers list in `config/app.php`.
```
\FlexFlux\Encryptor\EncryptorServiceProvider::class,
```

* Step 3: Add the Encryptable trait to your models you want to encrypt.
```
use FlexFlux\Encryptor\Encryptable;
use Encryptable;
```

* Step 4: Define which attributes you want to encrypt by adding them to your encryptable array inside the model.
```
protected $encryptable = [
        'name'
    ];
```

* Step 5: Make sure the attributes have the data type `text` inside your database. The encrypted data stored in the attribute can be longer then 255 characters.

#### PLEASE DO NOT encrypt passwords or e-mailaddresses used for authentication. The authentication won't work if you do this.

### Encrypt your production database ###
#### Requirements:
- All your models needs to be inside the `app\Models` folder of your Laravel project.
- You did all the installation steps above.
- You changed the data type of your encryptable attributes to text without compromising data.

#### To use Encryptor on an application already deployed to production we need to do the following steps on your production application:

* Step 0: Make sure you've made a backup of your database to restore in case anything goes wrong. Make sure you backup your APP_KEY in your `.env` file too.


* Step 1: First, make sure your application is not used by entering the following command inside your project folder: `php artisan down`. This will put your application offline for your users.


* Step 2: Remove (or comment) the Encryptable trait `use Encryptable;` in each model you added this to. Add the `FlexFlux\Encryptor\EncryptThis` trait from Encryptor instead by adding `use EncryptThis`. Make sure you still have the `protected $encryptable = []` array inside your model with the attributes you want to encrypt. We're going to use this variable. (You can also do this in a commit and push it to your production server or something like that)


* Step 3: Next, we run the following command: `php artisan encryptor:encrypt` inside your project folder. The command should now run through your Laravel models and encrypt each attribute on every row you wanted to encrypt.


* Step 4: Enable the `Encryptable` trait again on every model and remove the `EncryptThis` trait. (You can also do this in a commit and push it to your production server or something like that)


* Step 5: Put your application back online by entering the following command: `php artisan up` and your good to go! Your old and new database records are now encrypted at rest.

### Work in progress ###
- I'm planning to make it possible to search on encrypted attributes.

### DISCLAIMER ###
Please backup your APP_KEY from your production environment file. This key is used to encrypt and decrypt your data. Once you lost it, the data can never be decrypted.