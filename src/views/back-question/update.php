<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Question */

$this->title = 'Update Question: {nameAttribute}';

$this->params['breadcrumbs'][] = ['label' => 'Votes', 'url' => ['vote/index']];
$this->params['breadcrumbs'][] = ['label' => $model->vote->name, 'url' => ['vote/view', 'id' => $model->vote_id]];
$this->params['breadcrumbs'][] = ['label' => 'Questions', 'url' => ['index', 'vote_id' => $model->vote_id]];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="question-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
