<?php

namespace ityakutia\poll;

class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'ityakutia\poll\controllers';
    public $defaultRoute = 'poll';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
    }
}