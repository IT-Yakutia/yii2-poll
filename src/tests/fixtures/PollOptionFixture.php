<?php

namespace ityakutia\poll\tests\fixtures;

use ityakutia\poll\models\PollOption;
use yii\test\ActiveFixture;

class PollOptionFixture extends ActiveFixture
{
    public $modelClass = PollOption::class;
    public $dataFile = '@ityakutia/poll/tests/_data/poll_option.php';
    public $depends = [PollQuestionFixture::class];
}