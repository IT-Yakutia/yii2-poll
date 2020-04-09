<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Question */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="question-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'sort')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'type')
        ->dropDownList(
            $model::TYPES,           // Flat array ('id'=>'label')
            ['prompt'=>'выберите тип']    // options
        ); ?>

    <?= $form->field($model, 'photo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'show_for_option_id')->dropDownList(
        ArrayHelper::map(\common\models\Option::find()->where(['question_id' => $model->parent_id])->all(),'id','value'),
        [
            'prompt'=>($model->isNewRecord || $model->vote_id == null || count($model->parent) == 0 || count($model->parent->options) == 0) ? 'Поле будет доступно после сохранения, выбора опроса и при наличии вариантов ответа родительского вопроса' : 'Показывать для ответа',
            'disabled' => ($model->isNewRecord || $model->vote_id == null || count($model->parent) == 0 || count($model->parent->options) == 0) ? 'disabled' : false,
        ]
    ); ?>

    <?= $form->field($model, 'vote_id')->dropDownList(ArrayHelper::map(\common\models\Vote::find()->all(),'id','name'), ['prompt'=>'Выберите опрос']); ?>

    <?= $form->field($model, 'parent_id')->dropDownList(
        ArrayHelper::map(\common\models\Question::find()->where(['vote_id' => $model->vote_id])->andWhere(['<>','id', $model->id])->all(),'id','name'),
        [
            'prompt'=>($model->isNewRecord || $model->vote_id == null) ? 'Поле будет доступно после сохранения и выбора опроса' : 'Выберите родительский вопрос',
            'disabled' => ($model->isNewRecord || $model->vote_id == null) ? 'disabled' : false,
        ]
    ); ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
