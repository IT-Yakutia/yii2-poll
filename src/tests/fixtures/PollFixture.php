<?php

namespace ityakutia\poll\tests\fixtures;

use ityakutia\poll\models\Poll;
use yii\test\ActiveFixture;

class PollFixture extends ActiveFixture
{
    public $modelClass = Poll::class;
    public $dataFile = '@ityakutia/poll/tests/_data/poll.php';
}