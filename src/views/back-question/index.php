<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\QuestionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Questions';
$this->params['breadcrumbs'][] = ['label' => 'Votes', 'url' => ['vote/index']];
$this->params['breadcrumbs'][] = ['label' => \common\models\Vote::findOne($vote_id)->name, 'url' => ['vote/view', 'id' => $vote_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="question-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Question', ['create', 'vote_id' => $vote_id], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'sort',
            'photo',
            'name',
            'type',
            //'show_for_option_id',
            //'vote_id',
            //'parent_id',
            //'status',
            //'created_at',
            //'updated_at',

            ['class' => 'yii\grid\ActionColumn',
                'template'=>'{options}{view}{update}{delete}',
                'buttons'=>[
                    'options' => function ($url, $model) {     
                        return Html::a('<span class="glyphicon glyphicon-check"></span>', ['option/index', 'question_id' => $model->id], [
                                'title' => Yii::t('yii', 'options'),
                        ]);                                
                    }
                ]
            ],
        ],
    ]); ?>
</div>
