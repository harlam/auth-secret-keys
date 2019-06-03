Usage:

```php
/** Initialize service */
$generator = new KeyGenerator();
$validator = new KeyValidator();
$storage = new FSKeyStorage('/tmp/keys-storage');

$service = new SecretKeysService($generator, $validator, $storage);
/* Secret keys request interval (in seconds) */
$service->setRequestInterval(5); /* if not set - disabled */

/** Generate secret key with owner */
$key = $service->create('owner_name');

/** Validate secret key */
$isValid = $service->validate('owner_name', 123456);
print_r('Is valid: ' . ($isValid === true ? 'Yes' : 'No'));

```