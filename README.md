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

Utilisation
===========

```php
<?php
$user = $this->getUser();
$universign = $this->get('universign_request_manager');

$doc_html = '<html><body><p>Some Html</p></body></html>';
$doc_pdf = $this->get('knp_snappy.pdf')->getOutputFromHtml($voucher_html);

// Transaction
$transDoc = new TransactionDocument();
$transDoc->setName('Document Name');
$transDoc->setContent($doc_pdf);
$transSigner = new TransactionSigner(
    $user->getFirstname(),
    $user->getLastname(),
    $user->getEmail(),
    $user->getCompany(),
    $user->getPhone()
);

$transRequest = new TransactionRequest(
    [$transDoc],
    null,
    'http://example.com/success',
    [$transSigner],
    [
        TransactionRequest::KEY_OPTIONAL_IDENTIFICATION_TYPE => 'email',
        TransactionRequest::KEY_OPTIONAL_LANGUAGE               => 'fr',
        TransactionRequest::KEY_FINAL_DOC_SENT                  => true,
    ]
);

$transResponse = $universign->requestTransaction($transRequest);
```

Points d'attention
------------------
Le developpement s'est principalement basé sur la version 6.12 du document «UNIVERSIGN-GUIDE» et une grande partie
des commentaires présents dans le code retranscrivent le contenu du document. Cependant tous les parametres optionnels
n'ont pas été implémentés.

Dans l'ensemble, les objets dans le code reprennent le nommage de la documentation officielle.

Faker
-----
Il est possible de setter le parametre `universign_request_manager.class` avec la valeur
`Wizacha\UniversignBundle\Request\RequestManagerFaker`. Ce faker permet de tester les process metiers
sans utiliser de vraies signatures.

| Commande                     | Retour |
| ---------------------------- | ------ |
| RequestTransaction           | ['url' => l'url de succes qui est indiquée dans la request, 'id' => un `uniqid()` |
| getTransactionInfoByCustomId | La transaction est `completed` |
| getTransactionInfo           | La transaction est `completed` |
| getDocuments(id)             | le document a pour nom `id.doc` et pour contenu `idcontent` |

