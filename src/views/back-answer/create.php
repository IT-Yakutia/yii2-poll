<?php

use yii\helpers\Html;

$this->title = 'Вопрос Опроса';
?>
<div class="answer-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
