Usage:

```php
/** Initialize keys storage */
$keysStorage = new KeysStorage('/tmp/storage/secret-keys');

$keysManager = new KeysManager($keysStorage, new BaseGenerator());

/* Validation max attempts (default 3) */
$keysManager->setValidationMaxAttempts(5);

/* Secret key lifetime (default 300 sec.) */
$keysManager->setValidationMaxLifetime(300);

/* Secret key generation request interval (default 60 sec.) */
$keysManager->setRequestInterval(15);

/* Static keys (default empty) */
$keysManager->setPresetKeys(['owner' => 'static-secret']);

/** Generate secret key with owner */
$key = $keysManager->generate('owner');

/** Or validate secret key */
$key = (new KeyEntity)
    ->setOwner('owner')
    ->setKey('secret');

$keysManager->validate($key);
```