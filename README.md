Poll service for yii2
=====================
Poll server for yii2

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist it-yakutia/yii2-poll "*"
```

or add

```
"it-yakutia/yii2-poll": "*"
```

to the require section of your `composer.json` file.

Add migration path in your console config file:

```
'migrationPath' => [
    ...
    '@vendor/it-yakutia/poll/src/migrations',
],
```

Usage
-----

Once the extension is installed, simply use it in your code by  :

```php
<?= Url::toRoute(['/poll/poll/index']); ?>
```