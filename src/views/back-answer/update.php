<?php

use yii\helpers\Html;

$this->title = 'Обновление вопроса';

?>
<div class="answer-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
