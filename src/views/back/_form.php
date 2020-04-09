<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use uraankhayayaal\materializecomponents\imgcropper\Cropper;

?>

<div class="poll-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'type')
        ->dropDownList(
            $model::TYPES,           // Flat array ('id'=>'label')
            ['prompt' => 'выберите тип']    // options
        ); ?>

    <?= $form->field($model, 'photo')->widget(Cropper::class, [
        'aspectRatio' => 350 / 540,
        'maxSize' => [540, 350, 'px'],
        'minSize' => [10, 10, 'px'],
        'startSize' => [100, 100, '%'],
        'uploadUrl' => Url::to(['/poll/poll/uploadImg']),
    ]); ?>
    <small class="grey-text">Загружать изображения размером 540x350 пикселей</small>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>
    <div class="fixed-action-btn">
        <?= Html::submitButton('<i class="material-icons">save</i>', [
            'class' => 'btn-floating btn-large waves-effect waves-light tooltipped',
            'title' => 'Сохранить',
            'data-position' => "left",
            'data-tooltip' => "Сохранить",
        ]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>