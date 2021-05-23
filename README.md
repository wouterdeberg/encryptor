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

### Work in progress ###
- I'm planning to make it possible to search on encrypted attributes.
- I'm planning to make it possible to encrypt authentication attributes and still be able to use Laravel's authentication system.