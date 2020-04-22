<?php

use yii\helpers\Html;

$this->title = $model->title;

?>

<div class="poll" data-id="<?= $model->id ?>">
    <form action="#">
        <?php foreach ($model->pollQuestions as $key => $question) { ?>
            <div class="question" data-id="<?= $question->id ?>">
                <h3><?= $question->title ?></h3>
                <div class="options">
                    <?php foreach ($question->pollOptions as $key => $option) { ?>
                        <div class="option" data-id="<?= $option->id ?>">
                            <?php if($question->is_multi_select) { ?>    
                                <input id="<?= $model->id ?>-<?= $question->id ?>-<?= $option->id ?>" name="answer[<?= $model->id ?>][<?= $question->id ?>][<?= $option->id ?>]" type="checkbox">
                            <?php }else{ ?>
                                <input id="<?= $model->id ?>-<?= $question->id ?>-<?= $option->id ?>" name="answer[<?= $model->id ?>][<?= $question->id ?>][<?= $option->id ?>]" type="radio">
                            <?php } ?>
                            <label for="<?= $model->id ?>-<?= $question->id ?>-<?= $option->id ?>"><?= $option->title ?></label>
                        </div>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>

        <?= Html::hiddenInput('id', $model->id) ?>
        
        <p><input type="submit" value="Отправить"></p>
    </form>
</div>