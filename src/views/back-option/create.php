<?php

use yii\helpers\Html;

$this->title = 'Новый вариант ответа';

?>
<div class="poll-option-update">
    <div class="row">
        <div class="col s12">
		    <?= $this->render('_form', [
		        'model' => $model,
				'question' => $question,
			]) ?>
		</div>
	</div>
</div>
