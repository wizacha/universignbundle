Installation
============

Step 1: Download the Bundle
---------------------------
Soon


Step 2: Enable the Bundle
-------------------------
Soon
Then, enable the bundle by adding the following line in the `app/AppKernel.php`
file of your project:

```php
<?php
// app/AppKernel.php

// ...
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            // ...

            new <vendor>\<bundle-name>\<bundle-long-name>(),
        );

        // ...
    }

    // ...
}
```

TEST
======

```bash
$ composer install #composer must be installed
$ php vendor/atoum/atoum/bin/atoum -d Tests/ -bf Tests/bootstrap.php
```
