<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use uraankhayayaal\materializecomponents\checkbox\WCheckbox;

?>

<div class="poll-question-form">

    <?php $form = ActiveForm::begin([
        'errorCssClass' => 'red-text',
    ]); ?>

    <div class="row">
        <div class="col s12 m6">
            <?= WCheckbox::widget(['model' => $model, 'attribute' => 'is_publish']); ?>
        </div>
    </div>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?php if ($model->isNewRecord) echo Html::activeHiddenInput($model, 'poll_id', ['value' => $poll->id]) ?>

    <div class="row">
        <div class="col s12 m10 l8">
            <h5>Варианты ответов:</h5>
        </div>

        <div class="col s12 m10 l8 options-wrapper">
            <?php $number = 1; ?>
            <?php foreach ($model->pollOptions as $key => $option) { ?>
                <?php $row_key = $key +1; ?>
                <div class="form-group custom-poll-question-option" data-id="<?= $row_key ?>">
                    <input name="<?= Html::getInputName($model, 'options'); ?>[<?= $row_key ?>][id]" id="<?= Html::getInputId($model, 'options'); ?>-<?= $row_key ?>-id" type="hidden" value="<?= $option->id; ?>">
                    <label class="control-label active" for="<?= Html::getInputId($model, 'options'); ?>-<?= $row_key ?>-title">Вариант ответа <?= $row_key ?></label>
                    <input type="text" id="<?= Html::getInputId($model, 'options'); ?>-<?= $row_key ?>-title" class="form-control" name="<?= Html::getInputName($model, 'options'); ?>[<?= $row_key ?>][title]" value="<?= $option->title?>" maxlength="255" aria-required="true">
                    <div class="help-block"></div>
                </div>
            <?php } ?>
            <?php $next_key = isset($row_key) ? ($number + $row_key) : $number; ?>
            <div class="form-group custom-poll-question-option" data-id="<?= $next_key ?>">
                <label class="control-label active" for="<?= Html::getInputId($model, 'options'); ?>-<?= $next_key ?>-title">Вариант ответа <?= $next_key ?></label>
                <input type="text" id="<?= Html::getInputId($model, 'options'); ?>-<?= $next_key ?>-title" class="form-control" name="<?= Html::getInputName($model, 'options'); ?>[<?= $next_key ?>][title]" maxlength="255" aria-required="true">
                <div class="help-block"></div>
            </div>
        </div>
    </div>

<?php
$inputName = Html::getInputName($model, 'options');
$inputId = Html::getInputId($model, 'options');

$script = <<< JS
    function CheckToAddNewRow(optopn_input) {
        var options_wrapper = $(optopn_input).closest('.options-wrapper');
        var custom_poll_question_option = $(optopn_input).closest('.custom-poll-question-option');
        var data_id = custom_poll_question_option.data('id');
        var inputName = "$inputName";
        var inputId = "$inputId";
        data_id = data_id+1;
        if($(custom_poll_question_option).is(':last-child'))
        {
            options_wrapper.append(`
                <div class="form-group custom-poll-question-option" data-id="`+data_id+`">
                    <label class="control-label active" for="${inputId}-`+data_id+`-title">Вариант ответа `+data_id+`</label>
                    <input type="text" id="${inputId}-`+data_id+`-title" class="form-control" name="${inputName}[`+data_id+`][title]" maxlength="255" aria-required="true">
                    <div class="help-block"></div>
                </div>
            `);
        }
    }
    $(window).keyup(function(e) {
        if ( $(e.target).is('.custom-poll-question-option input') ){
            CheckToAddNewRow(e.target);
        }
    });
    
JS;

$this->registerJs($script, $this::POS_READY);

?>

    <div class="row">
        <div class="col 12">
            <div class="form-group">
                <?= Html::submitButton('Сохранить', ['class' => 'btn']) ?>
            </div>
        </div>
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