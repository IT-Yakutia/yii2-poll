<?php

use yii\helpers\Html;

$this->title = 'Новый вопрос';

?>
<div class="poll-question-update">
    <div class="row">
        <div class="col s12">
		    <?= $this->render('_form', [
		        'model' => $model,
		        'poll' => $poll,
		    ]) ?>
		</div>
	</div>
</div>
