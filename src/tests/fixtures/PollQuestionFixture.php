<?php

namespace ityakutia\poll\tests\fixtures;

use ityakutia\poll\models\PollQuestion;
use yii\test\ActiveFixture;

class PollQuestionFixture extends ActiveFixture
{
    public $modelClass = PollQuestion::class;
    public $dataFile = '@ityakutia/poll/tests/_data/poll_question.php';
    public $depends = [PollFixture::class];
}