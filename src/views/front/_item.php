<?php

use yii\helpers\Url;

?>

<div class="col-12 col-md-6">
    <a href="<?= Url::toRoute(['/poll/front/view', 'id' => $model->id])?>" class="pb-4 poll_item">
        <img class="w-100" src="<?= $model->photo ?>" alt="<?= $model->title; ?>">
        <time datetime="<?= Yii::$app->formatter->asDate($model->created_at); ?>"><?= Yii::$app->formatter->asDuration(time() - $model->created_at); ?></time>
        <p class="title"><?= $model->title; ?></p>
    </a>
</div>