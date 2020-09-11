<?php

use Faker\Factory;

$data = [];
$faker = Factory::create();
$params = require('_config.php');

for ($p = 0; $p < $params['pollCount']; $p++) {
    
    $poll_id = $p + 1;
    for ($q = 0; $q < $params['pollQuestionCount']; $q++) {
        $data[] = [
            'title' => 'Poll Question: title - ' . $faker->words($nb = rand(3, 6), $asText = true),
            'description' => 'Poll question description starts here - ' . $faker->words($nb = rand(10, 15), $asText = true),
            'poll_id' => $poll_id,
            'sort' => null,
            'is_publish' => round(rand(2, 10) / 10, 0),
            'status' => 10,
            'created_at' => '1581434317',
            'updated_at' => '1581434317',
        ];
    }
}

return $data;