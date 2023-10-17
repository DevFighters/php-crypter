# DEV FIGHTERS - PHP - Crypter

Installation
------------
* Install with composer
    ``` 
    composer require dev-fighters/php-crypter
    ```
* Requires PHP >= 8.2
* Encryption algorithm is **AEAD XChaCha20 Poly1305 IETF**

How to use
------------
Main file is ``\DF\Encryption\Crypter``

1. Generate a key : the key needs to be saved, or you can't decrypt further.
```php
    Crypter::generateKey()
```

2. Encrypt

```php
    $key = [KEY_GENERATED]
    $text = [TEXT_TO_ENCRYPT]
    $crypter = new Crypter($key);
    $encryptedText = $crypter->encrypt($text);
```

3. Decrypt

```php
    $key = [KEY_GENERATED]
    $textEncrypted = [TEXT_TO_DECRYPT]
    $crypter = new Crypter($key);
    $encryptedText = $crypter->decrypt($textEncrypted);
```

* Additional : check if a string is encrypted or not 

```php
    $key = [KEY_GENERATED]
    $text = [TEXT_TO_DECRYPT]
    $crypter = new Crypter($key);
    
    $crypter->isEncrypted($text);
    $crypter->isNotEncrypted($text);
```

All functions accessible
------------
```php
    static function generateKey() : string
    
    function encrypt(string $textToEncrypt) : string
    function decrypt(string $textEncrypted) : string
    
    function isEncrypted(string $textEncrypted) : bool 
    function isNotEncrypted(string $textEncrypted) : bool
```

