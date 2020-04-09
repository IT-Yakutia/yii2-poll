<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\OptionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$question = \common\models\Question::findOne($question_id);

$this->title = 'Options';
$this->params['breadcrumbs'][] = ['label' => 'Votes', 'url' => ['vote/index']];
$this->params['breadcrumbs'][] = ['label' => $question->vote->name, 'url' => ['vote/view', 'id' => $question->vote_id]];
$this->params['breadcrumbs'][] = ['label' => 'Questions', 'url' => ['question/index', 'vote_id' => $question->vote_id]];
$this->params['breadcrumbs'][] = ['label' => $question->name, 'url' => ['question/view', 'id' => $question_id]];

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="option-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Option', ['create', 'question_id' => $question_id], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'photo',
            'value',
            'type',
            'status',
            //'created_at',
            //'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
