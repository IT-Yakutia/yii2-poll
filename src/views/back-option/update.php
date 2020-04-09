<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Option */

$this->title = 'Update Option: {nameAttribute}';

$this->params['breadcrumbs'][] = ['label' => 'Votes', 'url' => ['vote/index']];
$this->params['breadcrumbs'][] = ['label' => $model->question->vote->name, 'url' => ['vote/view', 'id' => $model->question->vote_id]];
$this->params['breadcrumbs'][] = ['label' => 'Questions', 'url' => ['question/index', 'vote_id' => $model->question->vote_id]];
$this->params['breadcrumbs'][] = ['label' => $model->question->name, 'url' => ['question/view', 'id' => $model->question_id]];
$this->params['breadcrumbs'][] = ['label' => 'Options', 'url' => ['index', 'question_id' => $model->question_id]];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="option-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
