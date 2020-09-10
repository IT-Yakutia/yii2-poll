<?php

use Faker\Factory;
use ityakutia\poll\models\PollOption;
use ityakutia\poll\models\PollQuestion;

$data = [];
$faker = Factory::create();
$params = require('_config.php');

$options = PollOption::find()->all();

$ids = [];
foreach ($options as $option) {
    $ids[] = $option->id;
}

for ($o = 0; $o < $params['pollVoteCount']; $o++) {
    $data[] = [
        'poll_option_id' => $ids[rand(0, count($ids) - 1)]
    ];
}


return $data;
