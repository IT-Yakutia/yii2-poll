Poll service for yii2
=====================
Poll server for yii2

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```sh
php composer.phar require --prefer-dist it-yakutia/yii2-poll "*"
```

or add

```json
"it-yakutia/yii2-poll": "*"
```

to the require section of your `composer.json` file.

Add migration path in your console config file:

```php
'controllerMap' => [
    ...
    'migrate' => [
    ...
        'migrationPath' => [
            ...
            '@vendor/it-yakutia/poll/src/migrations',
        ],
    ],
]
```

Usage
-----

Once the extension is installed, simply use it in your code by  :

```php
<?= Url::toRoute(['/poll/poll/index']); ?>
```

Add RBAC roles:

```
poll
```

Add fixtures:

```sh
php yii fixture PollVote --namespace='ityakutia\poll\tests\fixtures'
```

Add fixtures in docker:

```sh
php yii fixture PollVote --namespace='ityakutia\poll\tests\fixtures' --interactive=0
```
