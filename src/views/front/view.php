<?php

$this->title = 'Первый опрос';

?>

<div class="poll" data-id="<?= $model->id ?>">
    <form action="#">
        <?php foreach ($model->questions as $key => $question) { ?>
            <div class="question" data-id="<?= $question->id ?>">
                <h3><?= $question->title ?></h3>
                <div class="options">
                    <?php foreach ($question->options as $key => $option) { ?>
                        <div class="option" data-id="<?= $option->id ?>">
                            <?php if($option->is_multi_select) { ?>    
                                <input id="<?= $poll->id ?>-<?= $question->id ?>-<?= $option->id ?>" name="answer[<?= $poll->id ?>][<?= $question->id ?>][<?= $option->id ?>]" type="checkbox">
                            <?php }else{ ?>
                                <input id="<?= $poll->id ?>-<?= $question->id ?>-<?= $option->id ?>" name="answer[<?= $poll->id ?>][<?= $question->id ?>][<?= $option->id ?>]" type="radio">
                            <?php } ?>
                            <label for="<?= $poll->id ?>-<?= $question->id ?>-<?= $option->id ?>"><?= $option->lable ?></label>
                        </div>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
        <p><input type="submit" value="Отправить"></p>
    </form>
</div>