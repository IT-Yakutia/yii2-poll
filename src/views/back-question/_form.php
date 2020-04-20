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
use yii\widgets\Pjax;

// для временных тестов
$options = [['id' => 1, 'title' => 'ну вот и что, ну вот и всё'], ['id' => 2, 'title' => 'пример номер 2']];

$savedOptions = [];
$savedOptionsCount = 0;
$deleteOptions = [];
foreach ($options as $key => $option) {
    $savedOptions[] =
        '<div class="col s12 m6 l4" id="optionCard' . $key . '" data-option="' . $option['id']/*->id*/ . '">'
        . '<div class="card">'
        . '<div class="card-content">'
        . '<p style="word-wrap: break-word"><a href="#!" id="optionDelete' . $key . '" onClick="deleteOption(' . $key . ')" class="secondary-content tooltipped" data-position="top" data-tooltip="Удалить ответ"><i id="optionUpdate' . $key . '" onClick="updateOption(' . $key . ')" class="material-icons right">delete</i></a><a href="#!" class="secondary-content tooltipped modal-trigger" data-position="top" data-tooltip="Редактировать ответ"><i class="material-icons right">edit</i></a><span class="optionTitle">' . $option['title']/*->title*/ . '</span></p>'
        . '</div>'
        . '</div>'
        . '</div>';
    $savedOptionsCount++;
}
$savedOptions = implode('', $savedOptions);

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
        <div class="col m12">
            <h5>Варианты ответов:</h5>
        </div>

        <div class="col m12">
            <div class="row" id="optionCards">
                <?= $savedOptions ?>
            </div>
        </div>

        <div class="col m12">
            <div class="row">
                <div class="input-field col s8 m6 l6">
                    <textarea id="optionInput" class="materialize-textarea" maxlength="255"></textarea>
                    <label for="optionInput" id="optionLabel">Добавьте новый ответ</label>
                </div>
                <div class="col s4 l4">
                    <a class="waves-effect waves-light btn" id="optionSubmit">Добавить</a>
                </div>
            </div>
        </div>
    </div>

    <?php

    $script = <<< JS

        // удаление 
        window.deleteOption = function(id) {
            let option = 'optionCard' + id;
            document.getElementById(option).remove();
        }

        // ввод текста
        $('#optionInput').keyup(function() {
            var textLen = maxLength - $(this).val().length;
            $('#optionLabel').html('Осталось символов:' + textLen);
        });

        var maxLength = 255;
        var optionId = $savedOptionsCount;

        //  добавление нового блока
        $('#optionSubmit').on('click', function() {
            var input = $('#optionInput').val();
            if(input != '') {
                $('#optionCards').append(
                    '<div class="col s12 m6 l4" id="optionCard' + optionId + '">' + 
                        '<div class="card">' + 
                            '<div class="card-content">' +
                                '<p style="word-wrap: break-word">' + 
                                    '<a href="#!" id="optionDelete' + optionId + '" onClick="deleteOption(' + optionId +')" class="secondary-content tooltipped" data-position="top" data-tooltip="Удалить ответ">' +
                                        '<i class="material-icons right">delete</i>' +
                                    '</a>' +
                                    '<a href="#!" id="optionUpdate' + optionId + '" onClick="updateOption(' + optionId +')" class="secondary-content tooltipped" data-position="top" data-tooltip="Редактировать ответ">' +
                                        '<i class="material-icons right">edit</i>' +
                                    '</a>' +
                                    '<span class="optionTitle">' + input + '</span>' +
                                '</p>' +
                            '</div>' +
                        '</div>' +
                    '</div>'
                );


                $('#optionInput').val('');
                textLen = 255;
                $('#optionLabel').html('Осталось символов: ' + textLen);
                optionId++;
            }
        });
    JS;

    $this->registerJs($script, $this::POS_READY);

    ?>

    <div class="row">
        <div class="col 12">
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