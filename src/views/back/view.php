<?php

use Faker\Factory;
use ityakutia\poll\models\PollQuestion;
use phpnt\chartJS\ChartJs;
use yii\helpers\Html;

$this->title = 'Результаты опроса: ' . $model->title;

?>

<div class="poll-view">
    <div class="row">
        <div class="col s8 m8">
            <p></p>
            <?= Html::a('Главная', ['/']) ?> /
            <?= Html::a('Опросы', ['index']) ?> /
            <?= Html::a('Просмотр опроса', ['view', 'id' => $model->id]) ?> /
			<?= Html::a('Редактирование опроса', ['update', 'id' => $model->id]) ?> /
			<?= Html::a('Вопросы', ['back-question/index', 'id' => $model->id]) ?>
            <p></p>

            <?php

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

                    $max = 0;
                    $options = $question->pollOptions;
                    if (!empty($options)) {
                        foreach ($options as $option) {
                            $votes = $option->pollVotesCount;
                            if ($max < $votes) {
                                $max = $votes;
                            }

                            $set = [];
                            $set['data'][] = $votes;
                            $set['backgroundColor'][] = '#' . substr(md5(rand()), 0, 6);
                            $set['label'] = $option->title;
                            $datasets[] = $set;
                        }
                    }

                    $data['data']['datasets'] = $datasets;
                    $options = [
                        'scales' => [
                            'yAxes' => [[
                                'display' => true,
                                'ticks' => [
                                    'beginAtZero' => true,
                                    'max' => $max + round($max / 10),
                                    'min' => 0
                                ]
                            ]]
                        ],
                    ];

                    $data['options'] = $options;
                    echo ChartJs::widget($data);
                }
            }

            ?>
        </div>
    </div>


</div>