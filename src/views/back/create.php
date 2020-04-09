<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model ityakutia\models\Poll */

$this->title = 'Создать опрос';
?>

<div class="poll-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
