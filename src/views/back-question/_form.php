<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use ityakutia\poll\models\Poll;
use uraankhayayaal\materializecomponents\checkbox\WCheckbox;
use uraankhayayaal\materializecomponents\grid\MaterialActionColumn;
use uraankhayayaal\sortable\grid\Column;
use yii\grid\GridView;
use yii\grid\SerialColumn;

// добавить добавление ответов с помощью jquery -> они добавляются, но сохраняются только в момент сохранения вопроса


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

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn']) ?>
        <?php if (!$model->isNewRecord) { ?>
            <?= Html::a(
                'Удалить вопрос',
                ['back-question/delete'],
                [
                    'class' => 'btn red',
                    'data' => [
                        'method' => 'post',
                        'params' => [
                            'id' => $model->id
                        ]
                    ]
                ]
            ) ?>
        <?php } ?>
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