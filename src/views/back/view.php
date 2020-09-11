<?php

use dosamigos\chartjs\ChartJs;
use Faker\Factory;
use ityakutia\poll\models\PollQuestion;
use practically\chartjs\Chart;
use yii\helpers\Html;

$this->title = 'Результаты опроса: ' . $model->title;

?>

<div class="poll-view">

    <div class="row">
        <div class="col s8 m8">
            <?php

            $faker = Factory::create();

            $questions = PollQuestion::find()->where(['poll_id' => $model->id])->all();
            if (!empty($questions)) {
                foreach ($questions as $question) {
                    echo Html::a("<h6>$question->title</h6>", ['back-question/update', 'id' => $question->id]);

                    $data = [
                        'type' => 'bar',
                        'data' => [
                            'labels' => [''],
                            'datasets' => []
                        ],
                    ];

                    $datasets = [];

                    $options = $question->pollOptions;
                    if (!empty($options)) {
                        foreach ($options as $option) {
                            $set = [];
                            $set['data'][] = $option->pollVotesCount;
                            $set['backgroundColor'][] = $faker->rgbCssColor;
                            $set['label'] = $option->title;
                            $datasets[] = $set;
                        }
                    }

                    $data['data']['datasets'] = $datasets;
                    echo ChartJs::widget($data);
                }
            }

            ?>
        </div>
    </div>


</div>