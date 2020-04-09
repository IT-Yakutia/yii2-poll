<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Question */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Votes', 'url' => ['vote/index']];
$this->params['breadcrumbs'][] = ['label' => $model->vote->name, 'url' => ['vote/view', 'id' => $model->vote_id]];
$this->params['breadcrumbs'][] = ['label' => 'Questions', 'url' => ['index', 'vote_id' => $model->vote_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="question-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Options', ['option/index', 'question_id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'type',
            'photo',
            'description:ntext',
            'show_for_option_id',
            'vote_id',
            'parent_id',
            'status',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
