<?php

use yii\helpers\Html;

$this->title = $is_voted ? 'Вы уже проголосовали в данном опросе!' : 'Спасибо что приняли участие в нашем опросе!';

?>

<div class="poll" data-id="<?= $model->id ?>">
    <h3><?= $this->title ?></h3>
    <p><?= $model->title ?></p>
    <?= Html::a('Вернуться на страницу опросов', ['index'], ['class' => 'btn']) ?>
</div>