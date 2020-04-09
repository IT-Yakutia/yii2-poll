<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Option */

$this->title = $model->id;

$this->params['breadcrumbs'][] = ['label' => 'Votes', 'url' => ['vote/index']];
$this->params['breadcrumbs'][] = ['label' => $model->question->vote->name, 'url' => ['vote/view', 'id' => $model->question->vote_id]];
$this->params['breadcrumbs'][] = ['label' => 'Questions', 'url' => ['question/index', 'vote_id' => $model->question->vote_id]];
$this->params['breadcrumbs'][] = ['label' => $model->question->name, 'url' => ['question/view', 'id' => $model->question_id]];
$this->params['breadcrumbs'][] = ['label' => 'Options', 'url' => ['index', 'question_id' => $model->question_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="option-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
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
            'photo',
            'value',
            'type',
            'question_id',
            'status',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
