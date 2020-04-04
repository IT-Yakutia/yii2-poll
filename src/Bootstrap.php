<?php

namespace ityakutia\poll;

use yii\base\BootstrapInterface;

class Bootstrap implements BootstrapInterface {

    public function bootstrap($app)
    {
        $app->setModule('poll', 'ityakutia\poll\Module');
    }
}