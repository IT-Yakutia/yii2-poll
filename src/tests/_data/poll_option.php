<?php

use Faker\Factory;
use ityakutia\poll\models\PollQuestion;

$data = [];
$faker = Factory::create();
$params = require('_config.php');

$questions = PollQuestion::find()->all();
foreach($questions as $question) {
    for ($o = 0; $o < $params['pollOptionCount']; $o++) {
        $data[] = [
            'title' => 'Poll Option: title - ' . $faker->words($nb = rand(3, 6), $asText = true),
            'poll_question_id' => $question->id,
            'sort' => null,
            'is_publish' => round(rand(2, 10) / 10, 0),
            'status' => 10,
            'created_at' => '1581434317',
            'updated_at' => '1581434317',
        ];
    }
}

return $data;
