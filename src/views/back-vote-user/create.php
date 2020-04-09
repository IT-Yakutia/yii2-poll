<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\VoteUser */

$this->title = 'Create Vote User';
$this->params['breadcrumbs'][] = ['label' => 'Vote Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vote-user-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
