<?php

use ityakutia\poll\models\PollQuestion;
use uraankhayayaal\sortable\grid\Column;
use uraankhayayaal\materializecomponents\grid\MaterialActionColumn;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use scotthuangzl\googlechart\GoogleChart;
use miloschuman\highcharts\Highcharts;

$this->title = 'Результаты опроса: ' . $model->title;

?>

<div class="poll-view">

    <div class="row">
        <div class="col s8 m8">
            <?php
            $questions = PollQuestion::find()->where(['poll_id' => $model->id])->all();
            foreach ($questions as $question) {
                // var_dump($question);
                $options = $question->pollOptions;
                // var_dump($options);
                $series = [];
                
                $seriesOptions = [];
                foreach ($options as $option) {
                    $seriesOptions[$option->title] = (int) $option->pollVotesCount;
                }

                ?>
                                    
                <?php
                // var_dump($series); die;

                echo Highcharts::widget([
                    'options' => [
                        'chart' => ['type' => 'column'],
                       'title' => ['text' => $question->title],
                       'plotOptions' => ['series' => ['stacking' => 'normal']],
                       'xAxis' => [
                          'categories' => array_keys($seriesOptions)
                       ],
                       'yAxis' => [
                          'title' => ['text' => 'Количество'],
                          'allowDecimals' => false
                       ],
                       'series' => [
                          ['name' => 'Количество голосов', 'colorByPoint' => true, 'data' => array_values($seriesOptions)],
                       ]
                    ]
                 ]);
            }
            ?>
        </div>
    </div>


</div>