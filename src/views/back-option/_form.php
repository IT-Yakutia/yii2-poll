<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Option */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="option-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'value')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'type')
        ->dropDownList(
            $model::TYPES,           // Flat array ('id'=>'label')
            ['prompt'=>'выберите тип']    // options
        ); ?>
        
    <?= $form->field($model, 'photo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'question_id')->dropDownList(ArrayHelper::map(\common\models\Question::find()/*->where(['vote_id' => $vote_id])*/->all(),'id','name'), ['prompt'=>'Выберите вопрос']); ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
