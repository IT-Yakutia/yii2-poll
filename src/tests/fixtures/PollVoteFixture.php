<?php

namespace ityakutia\poll\tests\fixtures;

use ityakutia\poll\models\PollVote;
use yii\test\ActiveFixture;

class PollVoteFixture extends ActiveFixture
{
    public $modelClass = PollVote::class;
    public $dataFile = '@ityakutia/poll/tests/_data/poll_vote.php';
    public $depends = [PollOptionFixture::class];
}