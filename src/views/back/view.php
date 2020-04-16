<?php

use ityakutia\poll\models\PollQuestion;
use uraankhayayaal\sortable\grid\Column;
use uraankhayayaal\materializecomponents\grid\MaterialActionColumn;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use scotthuangzl\googlechart\GoogleChart;

$this->title = 'Результаты опроса: ' . $model->title;

?>

<div class="poll-view">

    <div class="row">
        <div class="col s12 m12">
            <?php
            $questions = PollQuestion::find()->where(['poll_id' => $model->id])->all();
            foreach ($questions as $question) {
                // var_dump($question);
                $options = $question->pollOptions;
                // var_dump($options);
                $series = [];
                // $series[] = array('Task', 'Hours per Day');
                foreach ($options as $option) {
                    $series[] = [$option->title, (int) $option->pollVotesCount];
                }

                ?>
                    
                <?php
                // var_dump($series); die;

                echo \onmotion\apexcharts\ApexchartsWidget::widget([
                    'type' => 'bar', // default area
                    'height' => '400', // default 350
                    'width' => '500', // default 100%
                    'chartOptions' => [
                        'chart' => [
                            'toolbar' => [
                                'show' => true,
                                'autoSelected' => 'zoom'
                            ],
                        ],
                        'xaxis' => [
                            'type' => 'datetime',
                            // 'categories' => $categories,
                        ],
                        'plotOptions' => [
                            'bar' => [
                                'horizontal' => false,
                                'endingShape' => 'rounded'
                            ],
                        ],
                        'dataLabels' => [
                            'enabled' => false
                        ],
                        'stroke' => [
                            'show' => true,
                            'colors' => ['transparent']
                        ],
                        'legend' => [
                            'verticalAlign' => 'bottom',
                            'horizontalAlign' => 'left',
                        ],
                    ],
                    'series' => $series
                ]);
            }
            ?>
        </div>
    </div>


</div>