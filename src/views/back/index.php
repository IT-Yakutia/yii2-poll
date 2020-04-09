<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel ityakutia\models\PollSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Опросы';
?>
<div class="poll-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p><?= Html::a('Создать новый опрос', ['create'], ['class' => 'btn btn-success']) ?></p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'photo',
                'format' => 'raw',
                'value' => function($model){
                    return Html::img($model->photo, ['alt' => $model->name, 'class' => 'img-fluid img-thumbnail', 'width' => '150px']);
                }  
            ],
            'name',
            'type',
            //'status',
            //'created_at',
            //'updated_at',

            ['class' => 'yii\grid\ActionColumn',
                'template'=>'{questions}{view}{update}{delete}',
                'buttons'=>[
                    'questions' => function ($url, $model) {     
                        return Html::a('<span class="glyphicon glyphicon-list"></span>', ['question/index', 'poll_id' => $model->id], [
                                'title' => Yii::t('yii', 'questions'),
                        ]);                                
                    }
                ]  
            ],
        ],
    ]); ?>
</div>
