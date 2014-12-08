Installation
============

Step 1: Download the Bundle
---------------------------
Via composer

```
#!json
{
    "require": {
        "wizacha/universign-bundle": "dev-master"
    },
    "repositories": [
        {
            "type": "vcs",
            "url": "git@bitbucket.org:wizacha/universignbundle.git"
        }
    ]
}
```



Step 2: Enable the Bundle
-------------------------

Enable the bundle by adding the following line in the `app/AppKernel.php`
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

            new \Wizacha\UniversignBundle\WizachaUniversignBundle(),
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